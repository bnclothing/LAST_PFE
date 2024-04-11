<?php
include("../../php/database.php");
if (isset($_POST["submit"])) {

    // Handle form data
    $nom = $_POST['nom'];
    $dept_id = $_POST['dept_id'];

    $statement = $db->prepare("INSERT INTO fillieres (ID_DEPARTMENT, FILLIERE_NAME) VALUES (?, ?)");
    $statement->execute([$dept_id, $nom]);
}

    header("Location: ./index.php");
?>