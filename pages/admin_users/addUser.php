<?php
include("../../php/database.php");
session_start();

if (isset($_POST["submit"])) {
    // Handle form data
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $imagePath = '../../assets/images/user.png'; // Default value for image path

    // Handle file upload if a file is selected
    if (!empty($_FILES["image"]["name"])) {
        
        $targetDirectory = "../../assets/images/"; // Create this directory in your project
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Store file information in the database
            $imagePath = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Insert user data into the users table
    $statement = $db->prepare("INSERT INTO users (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ROLE, image) VALUES (?, ?, ?, ?, ?, ?)");
    $statement->execute([$prenom, $nom, $login, $password, $role, $imagePath]);

    // Retrieve the ID of the newly inserted user
    $userID = $db->lastInsertId();

    // Handle association with fillieres
    if (isset($_POST['fillieres'])) {
        $fillieres = $_POST['fillieres'];
        foreach ($fillieres as $filliereID) {
            // Insert association into users_fillieres_assoc table
            $statement = $db->prepare("INSERT INTO users_fillieres_assoc (User_ID, Filliere_ID) VALUES (?, ?)");
            $statement->execute([$userID, $filliereID]);
        }

        // Check if a group with the same department exists

        if ($role == 3) {
            $name_role = 'student';
        } elseif ($role == 2) {
            $name_role = 'teacher';
        }


        $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, ?)");
        $stmt->execute([$userID, 1, $name_role]); // Assuming the ID for the "Global Everyone" group is 1

        // Check if the user is a student or a teacher and add them to the appropriate group
        if ($role == 3) {
            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
            $stmt->execute([$userID, 3]); // Assuming the ID for the "Global Students" group is 3
        } elseif ($role == 2) {
            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
            $stmt->execute([$userID, 2]); // Assuming the ID for the "Global Teachers" group is 2
        }

        // part 2

        // Check if a group with the same filliere exists
        foreach ($fillieres as $filliereID) {
            $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE NAME = (SELECT FILLIERE_NAME FROM fillieres WHERE ID_FILLIERE = ?) AND entity_type = 'Filliere'");
            $stmt->execute([$filliereID]);
            $group = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$group) {
                // Create new groups for the filliere
                $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES ((SELECT FILLIERE_NAME FROM fillieres WHERE ID_FILLIERE = ?), 1, 'Filliere')");
                $stmt->execute([$filliereID]);
                $groupID1 = $db->lastInsertId();

                $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES ((SELECT FILLIERE_NAME FROM fillieres WHERE ID_FILLIERE = ?), 2, 'Filliere')");
                $stmt->execute([$filliereID]);
                $groupID2 = $db->lastInsertId();

                $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES ((SELECT FILLIERE_NAME FROM fillieres WHERE ID_FILLIERE = ?), 3, 'Filliere')");
                $stmt->execute([$filliereID]);
                $groupID3 = $db->lastInsertId();
            } else {
                $groupID1 = $group['ID_GROUP_DISCUSSION'];
                // Assuming types 1, 2, and 3 exist for the filliere
                $groupID2 = $groupID1 + 1;
                $groupID3 = $groupID1 + 2;
            }

            // Add the user to the groups based on their role
            if ($role == 3) { // Student
                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
                $stmt->execute([$userID, $groupID1]);

                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
                $stmt->execute([$userID, $groupID3]);
            } elseif ($role == 2) { // Teacher
                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
                $stmt->execute([$userID, $groupID1]);

                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
                $stmt->execute([$userID, $groupID2]);
            }
        }
    }


    // Query for retrieving departments
    $departmentsQuery = "SELECT DISTINCT d.Department_code
                      FROM users u
                      JOIN users_fillieres_assoc ufa ON u.ID_USER = ufa.User_ID
                      JOIN fillieres f ON ufa.Filliere_ID = f.ID_FILLIERE
                      JOIN departments d ON f.ID_DEPARTMENT = d.ID_DEPARTMENT
                      WHERE u.ID_USER = :user_id";

    $departmentsStatement = $db->prepare($departmentsQuery);
    $departmentsStatement->bindValue(':user_id', $userID);
    $departmentsStatement->execute();
    $departments = $departmentsStatement->fetchAll(PDO::FETCH_COLUMN);

    // Query for retrieving modules
    $modulesQuery = "SELECT DISTINCT m.MODULE_NAME
                 FROM users u
                 JOIN users_fillieres_assoc ufa ON u.ID_USER = ufa.User_ID
                 JOIN fillieres f ON ufa.Filliere_ID = f.ID_FILLIERE
                 LEFT JOIN modules_fillieres_association mfa ON f.ID_FILLIERE = mfa.id_filliere
                 LEFT JOIN modules m ON mfa.id_module = m.ID_MODULE
                 WHERE u.ID_USER = :user_id";

    $modulesStatement = $db->prepare($modulesQuery);
    $modulesStatement->bindValue(':user_id', $userID);
    $modulesStatement->execute();
    $modules = $modulesStatement->fetchAll(PDO::FETCH_COLUMN);




    foreach ($departments as $department) {
        $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE NAME = ? AND entity_type = 'Department'");
        $stmt->execute([$department]);
        $group = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$group) {
            // Create new groups for the department
            $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES (?, 1, 'Department')");
            $stmt->execute([$department]);
            $groupID1 = $db->lastInsertId();

            $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES (?, 2, 'Department')");
            $stmt->execute([$department]);
            $groupID2 = $db->lastInsertId();

            $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES (?, 3, 'Department')");
            $stmt->execute([$department]);
            $groupID3 = $db->lastInsertId();
        } else {
            $groupID1 = $group['ID_GROUP_DISCUSSION'];
            // Assuming types 1, 2, and 3 exist for the department
            $groupID2 = $groupID1 + 1;
            $groupID3 = $groupID1 + 2;
        }

        // Add the user to the groups based on their role
        if ($role == 3) { // Student
            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
            $stmt->execute([$userID, $groupID1]);

            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
            $stmt->execute([$userID, $groupID3]);
        } elseif ($role == 2) { // Teacher
            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
            $stmt->execute([$userID, $groupID1]);

            $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
            $stmt->execute([$userID, $groupID2]);
        }
    }

    foreach ($modules as $module) {
        if (!empty($module)) {
            $stmt = $db->prepare("SELECT * FROM groupdiscussion WHERE NAME = ? AND entity_type = 'Module'");
            $stmt->execute([$module]);
            $group = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$group) {
                // Create new groups for the module
                $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES (?, 1, 'Module')");
                $stmt->execute([$module]);
                $groupID1 = $db->lastInsertId();

                $stmt = $db->prepare("INSERT INTO groupdiscussion (NAME, TYPE, entity_type) VALUES (?, 3, 'Module')");
                $stmt->execute([$module]);
                $groupID3 = $db->lastInsertId();
            } else {
                $groupID1 = $group['ID_GROUP_DISCUSSION'];
                $groupID3 = $groupID1 + 1;
            }

            // Add the user to the groups based on their role
            if ($role == 3) { // Student
                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
                $stmt->execute([$userID, $groupID1]);

                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'student')");
                $stmt->execute([$userID, $groupID3]);
            } elseif ($role == 2) { // Teacher
                $stmt = $db->prepare("INSERT INTO groupmembership (ID_USER, ID_GROUP_DISCUSSION, ROLE) VALUES (?, ?, 'teacher')");
                $stmt->execute([$userID, $groupID1]);
            }
        }
    }


    header("Location: ./index.php");
    exit(); // Terminate the script execution after redirection
}
