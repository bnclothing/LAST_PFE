<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/users.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
</head>

<?php
include("../../php/database.php");

if (isset($_GET["delete"]) && !isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    // Show confirmation prompt before deleting
    echo '<script>';
    echo 'if (confirm("Are you sure you want to delete this user?")) {';
    echo '  window.location.href = "?delete=' . $idG . '&confirm_delete=1";';
    echo '}';
    echo '</script>';
}

// Handle confirmed deletion
if (isset($_GET["delete"]) && isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    $sql = $db->prepare("delete from users where ID_USER=$idG");
    $sql->execute();

    // Redirect back to the users.php page after deletion
    header("Location: index.php");
}

?>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>
    <div class="top">
        <div class="searchB">
            <input autocomplete="off" type="text" name="" id="search" placeholder="Search">
        </div>
        <div class="searchByB">
            <select name="" id="searchBy">
                <option value="FIRST_NAME">First name</option>
                <option value="LAST_NAME">Last name</option>
                <option value="name_role">User Role</option>
                <option value="Email">Email</option>
            </select>
        </div>
        <div class="addB">
            <input autocomplete="off" type="submit" value="add" id="AddUserButton" onclick="modal()">
        </div>
    </div>
    <section class="wrapper">
        <!-- Row title -->
        <main class="row title">
            <ul>
                <li>First name</li>
                <li>Last name</li>
                <li>User Role</li>
                <li>Email</li>
                <li>Password</li>
                <li>Operations</li>
            </ul>
        </main>
        <!-- Row 1 - fadeIn -->
        <div class="wrapperV2">
            <?php
            $sql = $db->prepare("SELECT * FROM users u,roles r where r.id_Role=u.ROLE and name_role not like 'admin' order by u.ID_USER");
            $sql->execute();
            $result = $sql->fetchAll();
            foreach ($result as $value) {
                echo '<section class="row-fadeIn-wrapper">';
                echo '<article class="row nfl">';
                echo "<ul>";
                echo "<li >" . $value["FIRST_NAME"] . "</li>";
                echo "<li>" . $value["LAST_NAME"] . "</li>";
                echo "<li>" . $value["name_role"] . "</li>";
                echo "<li>" . $value["EMAIL"] . "</li>";
                echo "<li>" . $value["PASSWORD"] . "</li>";
                echo "<li>";
                echo "<a  href=?edit=" . $value["ID_USER"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>";

                echo "&nbsp;&nbsp;&nbsp;";

                echo "<a href=?delete=" . $value["ID_USER"] . " id='delete'><span><i class='fa-solid fa-user-slash'></i></span></a>";
                echo "</li>";
                echo "</ul>";
                echo "</article>";
                echo "</section>";
            }
            ?>
        </div>
    </section>


    <?php
    include("../../includes/scripts.php");
    ?>

    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <form action="addUser.php" method="POST" class="addUserForm" enctype="multipart/form-data">

                <label for="nom">Nom:</label>
                <input autocomplete="off" type="text" name="nom" id="nom" required>

                <label for="prenom">Prenom:</label>
                <input autocomplete="off" type="text" name="prenom" id="prenom" required>

                <label for="login">Email:</label>
                <input autocomplete="off" type="text" name="login" id="login" required>

                <label for="password">Password: </label>
                <input autocomplete="off" type="password" name="password" id="password" required>

                <label for="role">Role: </label>
                <select name="role" id="role" onchange="updateFillieres()">
                    <option value="3">Student</option>
                    <option value="2">Teacher</option>
                </select>

                <label for="fillieres">Fillieres: </label>
                <select name="fillieres[]" id="fillieres">
                    <?php
                    // Fetch fillieres options from PHP without echoing them here
                    $sql = $db->prepare("SELECT * FROM fillieres");
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $filliere) {
                        echo '<option value="' . $filliere['ID_FILLIERE'] . '">' . $filliere['FILLIERE_NAME'] . '</option>';
                    }
                    ?>
                </select>

                <label for="image">Image:</label>
                <input autocomplete="off" type="file" name="image" id="image" accept="image/*">


                <div class="form-buttons">
                    <input autocomplete="off" type="submit" value="Ajouter" name="submit">
                    &nbsp;&nbsp;&nbsp;
                    <input autocomplete="off" type="reset" value="Annuler" name="reset" onclick="hide()">
                </div>
            </form>

        </div>
    </div>


    <div id="modifyUserModal" class="modal">
        <div class="modal-content">
            <?php
            $UserData = []; // Initialize $UserData to prevent potential errors
            if (isset($_GET['edit'])) {
                $iduv = $_GET['edit'];

                // Fetch the data of the file from the database
                $sql = $db->prepare("SELECT * FROM users u,roles r,users_fillieres_assoc a where r.id_Role=u.ROLE and a.USER_ID=u.ID_USER and ID_USER=?");
                $sql->execute([$iduv]);
                $UserData = $sql->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="updateUser.php" method="POST" class="addUserForm" enctype="multipart/form-data">
                <input autocomplete="off" type="text" name="Edited_user_ID" id="Edited_user_ID" value="<?php echo $iduv ?>" hidden>

                <label for="Edited_user_Nom">Nom:</label>
                <input autocomplete="off" type="text" name="Edited_user_Nom" id="Edited_user_Nom" value="<?php echo isset($UserData['LAST_NAME']) ? htmlspecialchars($UserData['LAST_NAME']) : ''; ?>" required>

                <label for="Edited_user_Prenom">Prenom:</label>
                <input autocomplete="off" type="text" name="Edited_user_Prenom" id="Edited_user_Prenom" value="<?php echo isset($UserData['FIRST_NAME']) ? htmlspecialchars($UserData['FIRST_NAME']) : ''; ?>" required>

                <label for="Edited_user_Email">Email:</label>
                <input autocomplete="off" type="text" name="Edited_user_Email" id="Edited_user_Email" value="<?php echo isset($UserData['EMAIL']) ? htmlspecialchars($UserData['EMAIL']) : ''; ?>" required>

                <label for="Edited_user_Password">Password:</label>
                <input autocomplete="off" type="password" name="Edited_user_Password" id="Edited_user_Password" required>

                <label for="Edited_user_Role">Role:</label>
                <select name="Edited_user_Role" id="Edited_user_Role" required onchange="updateEditedFillieres()">
                    <option value="2" <?php echo (isset($UserData['name_role']) && $UserData['name_role'] == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                    <option value="3" <?php echo (isset($UserData['name_role']) && $UserData['name_role'] == 'student') ? 'selected' : ''; ?>>Student</option>
                </select>

                <label for="Edited_user_fillieres">Fillieres: </label>
                <select name="fillieres[]" id="Edited_user_fillieres" <?php echo ($UserData['name_role'] == 'teacher') ? 'multiple="multiple"' : ''; ?>>
                    <?php
                    // Fetch fillieres options from PHP without echoing them here
                    $sql = $db->prepare("SELECT * FROM fillieres");
                    $sql->execute();
                    $result = $sql->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $filliere) {
                        // Check if the filliere is associated with the user
                        $isAssociated = false; // Default value
                        // Fetch fillieres associated with this user
                        $sql_assoc = $db->prepare("SELECT * FROM users_fillieres_assoc WHERE User_ID = ?");
                        $sql_assoc->execute([$iduv]);
                        $associated_fillieres = $sql_assoc->fetchAll(PDO::FETCH_COLUMN, 2); // Fetching only the Filliere_IDs
                        // Check if the current filliere is associated with the user
                        $isAssociated = in_array($filliere['ID_FILLIERE'], $associated_fillieres);

                        // Add the "selected" attribute if the filliere is associated with the user
                        echo '<option value="' . $filliere['ID_FILLIERE'] . '" ' . ($isAssociated ? 'selected' : '') . '>' . $filliere['FILLIERE_NAME'] . '</option>';
                    }
                    ?>
                </select>



                <label for="Edited_user_image">Image:</label>
                <input autocomplete="off" type="file" name="Edited_user_image" id="Edited_user_image" accept="image/*">

                <div class="form-buttons">
                    <input autocomplete="off" type="submit" value="Confirmer" name="update">
                    &nbsp;&nbsp;&nbsp;
                    <input autocomplete="off" type="reset" value="Annuler" name="reset" onclick="hide2()">
                </div>
            </form>


        </div>
    </div>

    <script src="../../js/admin.js"></script>

    <script>
        function updateFillieres() {
            var roleSelect = document.getElementById('role');
            var fillieresSelect = document.getElementById('fillieres');

            // Check if the selected role is "Teacher"
            if (roleSelect.value === '2') {
                // If it's a teacher, make the fillieres select multiple
                fillieresSelect.setAttribute('multiple', 'multiple');
            } else {
                // If it's not a teacher, remove the multiple attribute
                fillieresSelect.removeAttribute('multiple');
            }
        }

    </script>



</body>

</html>