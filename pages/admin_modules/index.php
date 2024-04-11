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
    echo 'if (confirm("Are you sure you want to delete this module?")) {';
    echo '  window.location.href = "?delete=' . $idG . '&confirm_delete=1";';
    echo '}';
    echo '</script>';
}

// Handle confirmed deletion
if (isset($_GET["delete"]) && isset($_GET["confirm_delete"])) {
    $idG = $_GET["delete"];
    $sql = $db->prepare("DELETE FROM modules WHERE ID_MODULE=?");
    $sql->execute([$idG]);

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
        <div class="top" style=" width: 100vw;">
            <div class="searchB">
                <input autocomplete="off" type="text" name="" id="search" placeholder="Search">
            </div>
            <div class="searchByB">
                <select name="" id="searchBy">
                    <option value="MODULE_NAME">Module</option>
                </select>
            </div>
            <div class="addB">
                <input autocomplete="off" type="submit" value="add" id="AddUserButton" onclick="modal()">
            </div>
        </div>
        <!-- ///////////////////////////////////////////////// -->
        <div class="top" style=" width: 100vw;">
            <h2>Les Relations entre les fillieres et les modules</h2>
        </div>
    </div>
    <div class="container" id="mainContainer">
        <section class="wrapper">
            <!-- Row title -->
            <main class="row title">
                <ul>
                    <li style="width: 75%;">modules</li>
                    <li style="width: 25%;">Operations</li>
                </ul>
            </main>
            <!-- Row 1 - fadeIn -->
            <div class="wrapperV2">
                <?php
                $sql = $db->prepare("SELECT * FROM modules");
                $sql->execute();
                $result = $sql->fetchAll();
                foreach ($result as $value) {
                    echo '<section class="row-fadeIn-wrapper">';
                    echo '<article class="row nfl">';
                    echo "<ul>";
                    echo "<li style=\"width: 75%;\">" . $value["MODULE_NAME"] . "</li>";
                    echo "<li style=\"width: 25%;\">
            <a href=?edit=" . $value["ID_MODULE"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href=?delete=" . $value["ID_MODULE"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
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
                    <li style="width: 40%;">filliere</li>
                    <li style="width: 40%;">modules</li>
                    <li style="width: 20%;">Operations</li>
                </ul>
            </main>
            <!-- Row 1 - fadeIn -->
            <div class="wrapperV2">
    <?php
    $sql = $db->prepare("SELECT f.FILLIERE_NAME, m.MODULE_NAME FROM fillieres f LEFT JOIN modules_fillieres_association a ON f.id_filliere = a.id_filliere LEFT JOIN modules m ON m.id_module = a.id_module");
    $sql->execute();
    $result = $sql->fetchAll();

    // Create an associative array to store modules for each filliere
    $fillieresData = array();

    foreach ($result as $value) {
        $filliereName = $value["FILLIERE_NAME"];
        $moduleName = $value["MODULE_NAME"];

        // Check if the filliere is already in the array
        if (!isset($fillieresData[$filliereName])) {
            $fillieresData[$filliereName] = array();
        }

        // Add module_name to the array for the corresponding filliere
        if ($moduleName) {
            $fillieresData[$filliereName][] = $moduleName;
        }
    }

    // Display the organized data
    foreach ($fillieresData as $filliereName => $modules) {
        echo '<section class="row-fadeIn-wrapper">';
        echo '<article class="row nfl">';
        echo "<ul>";
        echo "<li style=\"width: 40%;\">$filliereName</li>";

        // Display nested ul for module names if modules exist
        echo "<li style=\"width: 40%;\">";
        if (!empty($modules)) {
            echo "<ul>";
            foreach ($modules as $module) {
                echo "<li style=\"width: 100%;\">$module</li>";
            }
            echo "</ul>";
        }
        echo "</li>";
        echo "<li>";
        echo "<a href='module/?f=". $filliereName ."' id='delete'><span><i class='fa-solid fa-door-open'></i></span></a>";
        echo "</li>";
        echo "</ul>";
        echo "</article>";
        echo "</section>";
    }
    ?>
</div>

        </section>
    </div>



    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <form action="addModule.php" method="POST" class="addUserForm" enctype="multipart/form-data">

                <label for="nom">Module Name:</label>
                <input autocomplete="off" type="text" name="nom" id="nom" required>

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

                // Fetch the data of the module from the database
                $sql = $db->prepare("SELECT * FROM modules WHERE ID_MODULE=?");
                $sql->execute([$iduv]);
                $UserData = $sql->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form action="updateUser.php" method="POST" class="addUserForm">
                <input autocomplete="off" type="text" name="Edited_Module_ID" id="Edited_Module_ID" value="<?php echo $iduv ?>" hidden>

                <label for="Edited_Module_Nom">Nom:</label>
                <input autocomplete="off" type="text" name="Edited_Module_Nom" id="Edited_Module_Nom" value="<?php echo isset($UserData['MODULE_NAME']) ? htmlspecialchars($UserData['MODULE_NAME']) : ''; ?>" required>

                <div class="form-buttons">
                    <input autocomplete="off" type="submit" value="Confirmer" name="update">
                    &nbsp;&nbsp;&nbsp;
                    <input autocomplete="off" type="reset" value="Annuler" name="reset" onclick="hide2()">
                </div>
            </form>
        </div>
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

    <script src="../../js/admin.js"></script>

</body>

</html>