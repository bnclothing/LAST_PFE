<?php
include("../../php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $id = $_POST['Edited_Module_ID'];
    $module_name = $_POST['Edited_Module_Nom'];

    
    if (empty($_POST['Edited_Filliere_Nom']) || empty($_POST['Edited_Filliere_Dept'])) {
        echo "Please Fill in the fields";
    } else {
        $statement = $db->prepare("UPDATE `modules` SET `MODULE_NAME` = ? WHERE `ID_MODULE` = ?");
        $statement->execute([$module_name, $id]);
    }
}

header("Location: ./index.php");
