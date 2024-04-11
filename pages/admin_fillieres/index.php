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
    echo 'if (confirm("Are you sure you want to delete this filliere?")) {';
    echo '  window.location.href = "?delete=' . $idG . '&confirm_delete=1";';
    echo '}';
    echo '</script>';
}

// Handle confirmed deletion
if (isset($_GET["delete"]) && isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    $sql = $db->prepare("delete from fillieres where ID_FILLIERE=$idG");
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
    <div class="container" id="secondContainer">
        <div class="top" style="width: 100vw;">
            <div class="searchB">
                <input autocomplete="off" type="text" name="" id="search" placeholder="Search">
            </div>
            <div class="searchByB">
                <select name="" id="searchBy">
                    <option value="FILLIERE_NAME">filliere</option>
                </select>
            </div>
            <div class="addB">
                <input autocomplete="off" type="submit" value="add" id="AddUserButton" onclick="modal()">
            </div>
        </div>
        <!-- ///////////////////////////////////////////////// -->
        <div class="top" style="width: 100vw;">
            <h2>Les Relations entre les departements et les fillieres</h2>
        </div>
    </div>

    <div class="container" id="mainContainer">
        <section class="wrapper">
            <!-- Row title -->
            <main class="row title">
                <ul>
                    <li style="width: 75%;">filliere</li>
                    <li style="width: 25%;">Operations</li>
                </ul>
            </main>
            <!-- Row 1 - fadeIn -->
            <div class="wrapperV2">
                <?php
                $sql = $db->prepare("SELECT * FROM fillieres");
                $sql->execute();
                $result = $sql->fetchAll();
                foreach ($result as $value) {
                    echo '<section class="row-fadeIn-wrapper">';
                    echo '<article class="row nfl">';
                    echo "<ul>";
                    echo "<li style=\"width: 75%;\">" . $value["FILLIERE_NAME"] . "</li>";
                    echo "<li style=\"width: 25%;\">
            <a href=?edit=" . $value["ID_FILLIERE"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href=?delete=" . $value["ID_FILLIERE"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
                  </li>";
                    echo "</ul>";
                    echo "</article>";
                    echo "</section>";
                }
                ?>

            </div>
        </section>

        <button id="toggleButton" onclick="toggle()"><i class="fa-solid fa-arrows-left-right fa-2xl"></i></button>

        <section class="wrapper">
            <!-- Row title -->
            <main class="row title">
                <ul>
                    <li style="width: 50%;">department</li>
                    <li style="width: 50%;">fillieres</li>
                </ul>
            </main>
            <!-- Row 1 - fadeIn -->
            <div class="wrapperV2">
                <?php
                $sql = $db->prepare("SELECT * FROM fillieres f, departments d WHERE f.id_department = d.id_department");
                $sql->execute();
                $result = $sql->fetchAll();

                // Create an associative array to store fillieres for each department
                $departmentsData = array();

                foreach ($result as $value) {
                    $departmentName = $value["DEPARTMENT_NAME"];
                    $filliereName = $value["FILLIERE_NAME"];

                    // Check if the department is already in the array
                    if (!isset($departmentsData[$departmentName])) {
                        $departmentsData[$departmentName] = array();
                    }

                    // Add filliere_name to the array for the corresponding department
                    $departmentsData[$departmentName][] = $filliereName;
                }

                // Display the organized data
                foreach ($departmentsData as $departmentName => $fillieres) {
                    echo '<section class="row-fadeIn-wrapper">';
                    echo '<article class="row nfl">';
                    echo "<ul>";
                    echo "<li style=\"width: 50%;\">$departmentName</li>";

                    // Display nested ul for filliere_names
                    echo "<li style=\"width: 50%;\">";
                    echo "<ul>";
                    foreach ($fillieres as $filliere) {
                        echo "<li style=\"width: 100%;\">$filliere</li>";
                    }
                    echo "</ul>";
                    echo "</li>";
                    echo "</ul>";
                    echo "</article>";
                    echo "</section>";
                }
                ?>

            </div>
        </section>
    </div>

    <script>
        function toggle() {
            var container = document.getElementById("mainContainer");
            var secondContainer = document.getElementById("secondContainer");
            var currentTransform = container.style.transform;

            if (currentTransform === "translateX(-100vw)") {
                container.style.transform = "translateX(0)";
                secondContainer.style.transform = "translateX(0)";
            } else {
                container.style.transform = "translateX(-100vw)";
                secondContainer.style.transform = "translateX(-100vw)";
            }
        }
    </script>
    <?php
    include("../../includes/scripts.php");
    ?>

    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <form action="addFilliere.php" method="POST" class="addUserForm" enctype="multipart/form-data">

                <label for="nom">Filliere Name:</label>
                <input autocomplete="off" type="text" name="nom" id="nom" required>

                <label for="dept_id">Departement:</label>
                <select name="dept_id" id="dept_id">
                    <?php
                    include("../../php/database.php");

                    // Fetch department options from the database
                    $deptQuery = $db->prepare("SELECT ID_DEPARTMENT, DEPARTMENT_NAME FROM departments");
                    $deptQuery->execute();
                    $departments = $deptQuery->fetchAll();

                    // Dynamically generate options
                    foreach ($departments as $department) {
                        echo '<option value="' . $department['ID_DEPARTMENT'] . '">' . $department['DEPARTMENT_NAME'] . '</option>';
                    }
                    ?>
                </select>

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
                $sql = $db->prepare("SELECT * FROM fillieres where `ID_FILLIERE` = ?");
                $sql->execute([$iduv]);
                $UserData = $sql->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="updateFilliere.php" method="POST" class="addUserForm" enctype="multipart/form-data">
                <input autocomplete="off" type="text" name="Edited_Filliere_ID" id="Edited_Filliere_ID" value="<?php echo $iduv ?>" hidden>

                <label for="Edited_Filliere_Nom">Filliere Name:</label>
                <input autocomplete="off" type="text" name="Edited_Filliere_Nom" id="Edited_Filliere_Nom" value="<?php echo isset($UserData['FILLIERE_NAME']) ? htmlspecialchars($UserData['FILLIERE_NAME']) : ''; ?>" required>

                <label for="Edited_Filliere_Dept">Department:</label>
                <select name="Edited_Filliere_Dept" id="Edited_Filliere_Dept" required>
                    <?php
                    $sql = $db->prepare("SELECT * FROM departments");
                    $sql->execute();
                    $departments = $sql->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($departments as $dept) {
                        $deptID = $dept['ID_DEPARTMENT'];
                        $deptCode = $dept['Department_code'];
                        $deptName = $dept['DEPARTMENT_NAME'];

                        echo "<option value='$deptID' " . ($deptID == $UserData['ID_DEPARTMENT'] ? 'selected' : '') . ">$deptName</option>";
                    }
                    ?>
                </select>


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