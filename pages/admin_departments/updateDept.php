<?php
include("../../php/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $id = $_POST['Edited_dept_ID'];
    $dept_name = $_POST['Edited_dept_nom'];
    $dept_code = $_POST['Edited_dept_code'];

    if (empty($_POST['Edited_dept_nom']) || empty($_POST['Edited_dept_code'])) {
        echo "Please Fill in the fields";
    } else {
        $statement = $db->prepare("UPDATE `departments` SET `DEPARTMENT_NAME` = ?, `Department_code` = ? WHERE `ID_DEPARTMENT` = ?");
        $statement->execute([$dept_name, $dept_code, $id]);
    }
}

header("Location: ./index.php");
