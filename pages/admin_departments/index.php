<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/users.css">
<link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/solid.css">
</head>

<?php
include("../../php/database.php");
if (isset($_GET["delete"]) && !isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    // Show confirmation prompt before deleting
    echo '<script>';
    echo 'if (confirm("Are you sure you want to delete this depatment?")) {';
    echo '  window.location.href = "?delete=' . $idG . '&confirm_delete=1";';
    echo '}';
    echo '</script>';
}

// Handle confirmed deletion
if (isset($_GET["delete"]) && isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    $sql = $db->prepare("delete from departments where ID_DEPARTMENT=$idG");
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
                <option value="DEPARTMENT_NAME">Department name</option>
                <option value="Department_code">Department code</option>
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
                <li style="width: 60%;">Department name</li>
                <li style="width: 20%;">Department code</li>
                <li style="width: 20%;">Operations</li>
            </ul>
        </main>
        <!-- Row 1 - fadeIn -->
        <div class="wrapperV2">
            <?php
            $sql = $db->prepare("SELECT * FROM departments");
            $sql->execute();
            $result = $sql->fetchAll();
            foreach ($result as $value) {
                echo '<section class="row-fadeIn-wrapper">';
                echo '<article class="row nfl">';
                echo "<ul>";
                echo "<li style=\"width: 60%;\">" . $value["DEPARTMENT_NAME"] . "</li>";
                echo "<li style=\"width: 20%;\">" . $value["Department_code"] . "</li>";
                echo "<li style=\"width: 20%;\">
            <a href=?edit=" . $value["ID_DEPARTMENT"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href=?delete=" . $value["ID_DEPARTMENT"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
                  </li>";
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
            <form action="addDept.php" method="POST" class="addUserForm" enctype="multipart/form-data">

                <label for="nom">Departement Name:</label>
                <input autocomplete="off" type="text" name="nom" id="nom" required>

                <label for="code">Departement Code:</label>
                <input autocomplete="off" type="text" name="code" id="code" required>

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
                $sql = $db->prepare("SELECT * FROM departments where id_department=?");
                $sql->execute([$iduv]);
                $UserData = $sql->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="updateDept.php" method="POST" class="addUserForm">
                <input autocomplete="off" type="text" name="Edited_dept_ID" id="Edited_dept_ID" value="<?php echo $iduv ?>" hidden>

                <label for="nom">Departement Name:</label>
                <input autocomplete="off" type="text" name="Edited_dept_nom" id="Edited_dept_nom" value="<?php echo $UserData['DEPARTMENT_NAME'] ?>" required>

                <label for="code">Departement Code:</label>
                <input autocomplete="off" type="text" name="Edited_dept_code" id="Edited_dept_code" value="<?php echo $UserData['Department_code'] ?>" required>

                <div class="form-buttons">
                    <input autocomplete="off" type="submit" value="Confirmer" name="update">
                    &nbsp;&nbsp;&nbsp;
                    <input autocomplete="off" type="reset" value="Annuler" name="reset" onclick="hide2()">
                </div>
            </form>
        </div>
    </div>

    <script src="../../js/admin.js"></script>

</body>

</html>