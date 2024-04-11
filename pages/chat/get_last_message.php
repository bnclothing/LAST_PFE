<?php
include("../../php/database.php");
session_start();

function getLastMessageForGroup($groupID) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM (SELECT m.*, u.FIRST_NAME, u.LAST_NAME FROM message m JOIN users u ON m.ID_USER = u.ID_USER WHERE m.ID_GROUP_DISCUSSION = :group_id ORDER BY m.TIMESTAMP DESC LIMIT 1) AS sub ORDER BY sub.TIMESTAMP ASC");
    $stmt->bindParam(':group_id', $groupID, PDO::PARAM_INT);
    $stmt->execute();
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($message) {
        if (substr($message['CONTENT'], 0, 4) === 'FILE') {
            // Display file type
            $filePath = "../../assets/chatAssets/" . $message['CONTENT'];
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
    
            // Check file type and display accordingly
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                // Display image
                return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'Image' : $message['LAST_NAME'] . " : " . 'Image';
            } elseif (in_array($fileExtension, ['mp4', 'webm', 'ogg'])) {
                // Display video
                return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'Video' : $message['LAST_NAME'] . " : " . 'Video';
            } elseif (in_array($fileExtension, ['mp3', 'wav', 'ogg'])) {
                // Display audio
                return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'Music' : $message['LAST_NAME'] . " : " . 'Music';
            } elseif (in_array($fileExtension, ['pdf'])) {
                // Display PDF
                return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'PDF' : $message['LAST_NAME'] . " : " . 'PDF';
            } else {
                return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'File' : $message['LAST_NAME'] . " : " . 'File';
            }
        } else if (substr($message['CONTENT'], 0, 2) === 'SR') {
            // Display audio record
            return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . 'Audio Record' : $message['LAST_NAME'] . " : " . 'Audio Record';
        } else {
            // Display text message
            return ($message['ID_USER'] == $_SESSION["id_user"]) ? 'Me' . " : " . $message['CONTENT'] : $message['LAST_NAME'] . " : " . $message['CONTENT'];
        }
    } else {
        return 'No messages';
    }
    
}

// Check if group_id is set in the GET request
if (isset($_GET['group_id'])) {
    $groupID = $_GET['group_id'];
    $lastMessage = getLastMessageForGroup($groupID);
    echo $lastMessage;
} else {
    echo 'Error: group_id parameter is missing';
}


?>
