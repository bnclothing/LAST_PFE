<?php
include("../../php/database.php");
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the message content, group ID, and chat type
    $content = trim($_POST["message_content"]);
    $groupID = $_POST["group_id"];
    $chatType = isset($_POST["chat_type"]) ? $_POST["chat_type"] : "";
    $userID = $_SESSION["id_user"]; // Assuming this is the ID of the logged-in user

    // Check if the message content is not empty
    if (!empty($content) || $content == "0") {
        // Insert the message into the database
        $stmt = $db->prepare("INSERT INTO message (ID_USER, ID_GROUP_DISCUSSION, CONTENT, TIMESTAMP) VALUES (:user_id, :group_id, :content, NOW())");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':group_id', $groupID, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();

        // Get the last inserted ID
        $lastInsertId = $db->lastInsertId();

        
        echo $lastInsertId;
        exit();
    } else {
        // Redirect back to the chat page if the message content is empty
        header("Location: index.php?chat_type=$chatType&group_id=$groupID");
        exit();
    }
}
