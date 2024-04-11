<?php
include("../../php/database.php");

if (isset($_POST['update'])) {
    $id = $_POST['Edited_user_ID'];
    $nom = $_POST['Edited_user_Nom'];
    $prenom = $_POST['Edited_user_Prenom'];
    $email = $_POST['Edited_user_Email'];
    $password = $_POST['Edited_user_Password'];
    $role = $_POST['Edited_user_Role'];

    // Handle file upload if a new image is provided
    if ($_FILES['Edited_user_image']['error'] == UPLOAD_ERR_OK) {
        // Handle file upload
        $targetDirectory = "../../assets/images/";
        $targetFile = $targetDirectory . basename($_FILES["Edited_user_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an actual image
        $check = getimagesize($_FILES["Edited_user_image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Retrieve the old image path to delete it
            $oldImagePath = "";
            $sql = $db->prepare("SELECT `image` FROM `users` WHERE `ID_USER` = ?");
            $sql->execute([$id]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $oldImagePath = $result['image'];
            }

            // Delete the old image if it exists
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload the new image
            if (move_uploaded_file($_FILES["Edited_user_image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;

                // Update user data in the database including the new image path
                $statement = $db->prepare("UPDATE `users` SET `LAST_NAME` = ?, `FIRST_NAME` = ?, `EMAIL` = ?, `PASSWORD` = ?, `ROLE` = ?, `image` = ? WHERE `ID_USER` = ?");
                $statement->execute([$nom, $prenom, $email, $password, $role, $imagePath, $id]);
                echo "The file " . basename($_FILES["Edited_user_image"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no new image is provided, update user data without changing the image
        $statement = $db->prepare("UPDATE `users` SET `LAST_NAME` = ?, `FIRST_NAME` = ?, `EMAIL` = ?, `PASSWORD` = ?, `ROLE` = ? WHERE `ID_USER` = ?");
        $statement->execute([$nom, $prenom, $email, $password, $role, $id]);
    }

    // Handle association with fillieres
    $statement = $db->prepare("DELETE FROM `users_fillieres_assoc` WHERE `User_ID` = ?");
    $statement->execute([$id]);

    if (isset($_POST['fillieres'])) {
        $fillieres = $_POST['fillieres'];
        foreach ($fillieres as $filliereID) {
            // Insert association into users_fillieres_assoc table
            $statement = $db->prepare("INSERT INTO `users_fillieres_assoc` (`User_ID`, `Filliere_ID`) VALUES (?, ?)");
            $statement->execute([$id, $filliereID]);
        }
    }

    // Redirect to index.php after update
    header("Location: ./index.php");
    exit(); // Terminate the script execution after redirection
}
?>
