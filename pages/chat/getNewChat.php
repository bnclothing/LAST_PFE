<?php
include("../../php/database.php");
session_start();

function formatBytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

$lastMessageID = isset($_POST['lastMessageID']) ? $_POST['lastMessageID'] : '';
$selectedGroupID = isset($_POST['group_id']) ? $_POST['group_id'] : '';
// Fetch messages for the selected group
$messages = [];
if (!empty($selectedGroupID)) {
    $stmt = $db->prepare("SELECT * FROM (SELECT m.*, u.FIRST_NAME, u.LAST_NAME 
    FROM message m JOIN users u 
    ON m.ID_USER = u.ID_USER 
    WHERE m.ID_GROUP_DISCUSSION = :group_id 
    AND m.ID_MESSAGE > :lastMessageID 
    ORDER BY m.TIMESTAMP DESC LIMIT 15) AS sub 
    ORDER BY sub.TIMESTAMP ASC");
    $stmt->bindParam(':group_id', $selectedGroupID, PDO::PARAM_INT);
    $stmt->bindParam(':lastMessageID', $lastMessageID, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Display messages
if (!empty($messages)) {
    $prevDate = null;
    foreach ($messages as $message) {

        $currentDate = date('Y-m-d', strtotime($message['TIMESTAMP']));
        if ($currentDate !== $prevDate) {
            if ($currentDate === date('Y-m-d')) {
                echo '<hr class="hr-text"  data-content="Today">';
            } elseif ($currentDate === date('Y-m-d', strtotime('-1 day'))) {
                echo '<hr class="hr-text"  data-content="Yesterday">';
            } else {
                echo '<hr class="hr-text"  data-content="' . $currentDate . '"> ';
            }
            $prevDate = $currentDate;
        }

        echo '<li class="' . ($message['ID_USER'] == $_SESSION["id_user"] ? 'self' : 'other') . '">';
        echo '<div class="msg">';
        if ($message['ID_USER'] != $_SESSION["id_user"]) {
            echo '<div class="user">' . $message['FIRST_NAME'] . ' ' . $message['LAST_NAME'] . '</div>';
        }
        if (substr($message['CONTENT'], 0, 4) === 'FILE') {
            $filePath = "../../assets/chatAssets/" . $message['CONTENT'];

            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);


            // Check file type and display accordingly
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                // Display image
                echo '<img src="' . $filePath . '" alt="Image">';
            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                // Display video
                echo '<video controls><source src="' . $filePath . '" type="video/' . $fileExtension . '"></video>';
            } elseif (in_array($fileExtension, ['mp3', 'wav', 'ogg'])) {
                // Display audio
                echo '<audio controls><source src="' . $filePath . '" type="audio/' . $fileExtension . '"></audio>';
            } elseif (in_array($fileExtension, ['pdf'])) {
                // Display PDF as a download link
                echo '<iframe src="' . $filePath . '" type="application/pdf"></iframe>';
            } else {
                // Display a generic download link for other file types
                $fileSize = filesize($filePath);

                echo '<button onclick="this.querySelector(\'#LinkForDownload\').click()">
                        <div class="informations">
                            <i class="fa-solid fa-file"></i>
                            <p>' . $message['file_path'] . '</p>
                            <p>' . formatBytes($fileSize) . '</p>
                        </div>
                        <a id="LinkForDownload" href="' . $filePath . '" download="' . $message['file_path'] . '"><i class="fa-regular fa-circle-down fa-shake" style="color: #000000;"></i></a>
                    </button>';
            }
        } else if (substr($message['CONTENT'], 0, 2) === 'SR') {
            $filePath = "../../assets/Audio/" . $message['CONTENT'];

            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            echo '<audio controls><source src="' . $filePath . '" type="audio/' . $fileExtension . '"></audio>';
        } else {
            // Otherwise, display it as a paragraph
            echo '<p>' . $message['CONTENT'] . '</p>';
        }
        echo '<time>' . date('H:i', strtotime($message['TIMESTAMP'])) . '</time>';
        echo '</div>';
        echo '</li>';

    }
}
