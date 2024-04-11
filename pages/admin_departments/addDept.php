<?php
include("../../php/database.php");
if (isset($_POST["submit"])) {

    // Handle form data
    $nom = $_POST['nom'];
    $code = $_POST['code'];
    $statement = $db->prepare("INSERT INTO departments (Department_code, DEPARTMENT_NAME) VALUES (?, ?)");
    $statement->execute([$code, $nom]);
}

    header("Location: ./index.php");
?>