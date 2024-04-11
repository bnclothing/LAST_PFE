<?php
include("../../php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $id = $_POST['Edited_Filliere_ID'];
    $filliere_name = $_POST['Edited_Filliere_Nom'];
    $dept_id = $_POST['Edited_Filliere_Dept'];
    
    if (empty($_POST['Edited_Filliere_Nom']) || empty($_POST['Edited_Filliere_Dept'])) {
        echo "Please Fill in the fields";
    } else {
        $statement = $db->prepare("UPDATE `fillieres` SET `FILLIERE_NAME` = ?, `ID_DEPARTMENT` = ? WHERE `ID_FILLIERE` = ?");
        $statement->execute([$filliere_name, $dept_id, $id]);
    }
}

header("Location: ./index.php");
