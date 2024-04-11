<?php
session_start();
include("../../php/database.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the group ID
    $groupID = $_POST["group_id"];
    $userID = $_SESSION["id_user"]; // Assuming this is the ID of the logged-in user

    // Check if a file was uploaded
    if (isset($_FILES["file_upload"]) && $_FILES["file_upload"]["error"] == UPLOAD_ERR_OK) {
        // Specify the upload directory
        $uploadDir = "../../assets/Audio/";

        // Generate a unique filename
        $prefix = "SR-"; // Add your prefix here
        $fileName = $prefix . uniqid() . "_" . basename($_FILES["file_upload"]["name"]);

        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $filePath)) {
            // File moved successfully
            // Insert the message into the database
            $stmt = $db->prepare("INSERT INTO message (ID_USER, ID_GROUP_DISCUSSION, CONTENT, file_path, TIMESTAMP) VALUES (:user_id, :group_id, :content, :fName, NOW())");
            $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':group_id', $groupID, PDO::PARAM_INT);
            $stmt->bindParam(':content', $fileName, PDO::PARAM_STR); // Use the file name as the content
            $stmt->bindParam(':fName', $_FILES["file_upload"]["name"], PDO::PARAM_STR); // Use the file name as the content
            $stmt->execute();

            echo "File uploaded and message sent successfully.";
        } else {
            // File move failed
            http_response_code(500); // Internal Server Error
            echo "Failed to move the uploaded file.";
        }
    } else {
        http_response_code(400); // Bad Request
        echo "No file uploaded or an error occurred.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed.";
}
