<!DOCTYPE html>
<html lang="en">

<?php
include("../../../php/database.php");
session_start();

$cmp = 0;
if ($_SESSION["login"] == 1) {
    $cmp = 1;
}
if ($cmp == 0) {
    header("location:../../../");
}

if (!isset($_GET['f'])) {
    header("Location: ../index.php");
    exit;
} else {
    $filliere = $_GET['f'];
}

//Delete Module From a filliere
if (isset($_GET['DeleteM']) && isset($_GET['DeleteF'])) {
    $sql = $db->prepare("DELETE FROM modules_fillieres_association WHERE ID_MODULE = ? AND id_filliere= ?");
    $sql->bindParam(1, $_GET['DeleteM'], PDO::PARAM_INT);
    $sql->bindParam(2, $_GET['DeleteF'], PDO::PARAM_INT);
    $sql->execute();

    // Construct the redirect URL with only the 'f' parameter
    $redirectUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $redirectUrl = strtok($redirectUrl, '?'); // Remove existing query string
    $redirectUrl .= "?f=" . urlencode($filliere); // Add 'f' parameter with the same value
    header("Location: $redirectUrl");
    exit;
}

//Add Module To a filliere
if (isset($_GET['AddedM']) && isset($_GET['AddedF'])) {
    $sql = $db->prepare("INSERT INTO modules_fillieres_association (id_filliere, id_module) VALUES (?, ?)");
    $sql->bindParam(1, $_GET['AddedF'], PDO::PARAM_INT);
    $sql->bindParam(2, $_GET['AddedM'], PDO::PARAM_INT);
    $result = $sql->execute();



    // Construct the redirect URL with only the 'f' parameter
    $redirectUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $redirectUrl = strtok($redirectUrl, '?'); // Remove existing query string
    $redirectUrl .= "?f=" . urlencode($filliere); // Add 'f' parameter with the same value
    header("Location: $redirectUrl");
    exit;
}

?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="../../../css/help.css">
    <link rel="stylesheet" href="../../../css/home.css">
    <link rel="stylesheet" href="../../../css/module.css">
    <link rel="stylesheet" href="../../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../../fontawesome-free-6.5.1-web/css/solid.css">
</head>

<body>
    <?php
    include("../../../includes/help.php");
    ?>

    <div class="screen">
        <div class="back-container">
            <button class="btn Back" onclick="window.location.href='../'">Back</button>
        </div>
        <div class="content">
            <div class="filliere">
                <?php echo "$filliere"; ?>
            </div>
            <div class="selected-modules">
                <div class="line">
                    <div class="col" style="width: 70%;">
                        <?PHP
                        $sql = $db->prepare("SELECT ID_FILLIERE FROM fillieres WHERE FILLIERE_NAME = ?");
                        $sql->bindParam(1, $filliere, PDO::PARAM_STR);
                        $sql->execute();
                        $result = $sql->fetch(PDO::FETCH_ASSOC);
                        $F_ID = $result['ID_FILLIERE'];

                        $sql = $db->prepare("SELECT * FROM modules WHERE ID_MODULE IN (SELECT id_module FROM modules_fillieres_association WHERE id_filliere = ?)");
                        $sql->bindParam(1, $F_ID, PDO::PARAM_STR);
                        $sql->execute();
                        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <select name="" class="module-input" id="moduleEdit">
                            <?php
                            // Loop through each result and create an option for each module
                            foreach ($result as $row) {
                                echo '<option value="' . $row['ID_MODULE'] . '" class="module">' . $row['MODULE_NAME'] . '</option>';
                            }
                            ?>
                        </select>



                    </div>
                    <div class="col" style="width: 30%;">
                        <?php
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

                        echo "<a id='delete' onclick='Delete($F_ID);'><span><i class='fa-solid fa-user-slash fa-xl'></i></span></a>";

                        ?>
                    </div>
                </div>
            </div>
            <div class="modules">
                <?PHP
                $sql = $db->prepare("SELECT * FROM modules WHERE ID_MODULE NOT IN (SELECT id_module FROM modules_fillieres_association WHERE id_filliere = ?)");
                $sql->bindParam(1, $F_ID, PDO::PARAM_STR);
                $sql->execute();
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <select name="" class="module-input" id="modulesToAdd">
                    <option value="" class="module" selected disabled>--- Select Module To Add ---</option>
                    <?php
                    // Loop through each result and create an option for each module
                    foreach ($result as $row) {
                        echo '<option value="' . $row['ID_MODULE'] . '" class="module">' . $row['MODULE_NAME'] . '</option>';
                    }
                    echo '</select>';
                    echo "<a href='#' onclick=ADD($F_ID) class='btn Add'>ADD</a>";
                    ?>

            </div>
        </div>

        <script>
            function Delete(filliere_ID) {
                var selectElement = document.getElementById("moduleEdit");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var selectedValue = selectedOption.value;
                var selectedText = selectedOption.textContent;
                var confirmDelete = confirm("Are you sure you want to delete " + selectedText + "?");

                if (confirmDelete) {
                    // Check if current URL already contains GET parameters
                    var separator = window.location.href.indexOf('?') !== -1 ? '&' : '?';
                    // Construct the new URL with the additional GET parameters
                    var newUrl = window.location.href + separator + "AddedeM=" + selectedValue + "&DeleteF=" + filliere_ID;
                    // Redirect the user to the new URL
                    window.location.href = newUrl;
                }
            }

            function ADD(filliere_ID) {
                var selectElement = document.getElementById("modulesToAdd");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                var selectedValue = selectedOption.value;
                var selectedText = selectedOption.textContent;

                // Check if current URL already contains GET parameters
                var separator = window.location.href.indexOf('?') !== -1 ? '&' : '?';
                // Construct the new URL with the additional GET parameters
                var newUrl = window.location.href + separator + "AddedM=" + selectedValue + "&AddedF=" + filliere_ID;
                // Redirect the user to the new URL
                window.location.href = newUrl;
            }
        </script>



        <?php
        include("../../../includes/scripts.php");
        ?>
</body>

</html>