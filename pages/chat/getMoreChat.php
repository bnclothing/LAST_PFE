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

$messageId = isset($_POST['first_message_id']) ? $_POST['first_message_id'] : '';
$selectedGroupID = isset($_POST['group_id']) ? $_POST['group_id'] : '';
// Fetch messages for the selected group
$messages = [];
if (!empty($selectedGroupID)) {
    $stmt = $db->prepare("SELECT * FROM (SELECT m.*, u.FIRST_NAME, u.LAST_NAME 
    FROM message m JOIN users u 
    ON m.ID_USER = u.ID_USER 
    WHERE m.ID_GROUP_DISCUSSION = :group_id 
    AND m.ID_MESSAGE < :message_id 
    ORDER BY m.TIMESTAMP DESC LIMIT 15) AS sub 
    ORDER BY sub.TIMESTAMP ASC");
    $stmt->bindParam(':group_id', $selectedGroupID, PDO::PARAM_INT);
    $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate and add file size for each file message
    foreach ($messages as &$message) {
        if (substr($message['CONTENT'], 0, 4) === 'FILE') {
            $filePath = "../../assets/chatAssets/" . $message['CONTENT'];
            $fileSize = filesize($filePath);
            $message['file_size'] = formatBytes($fileSize);
        }
    }
}
// Prepare the response data
$response = [
    'messages' => $messages,  // Include all messages
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
