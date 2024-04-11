<?php
include("../../php/database.php");
if (isset($_POST["submit"])) {

    // Handle form data
    $nom = $_POST['nom'];
    $statement = $db->prepare("INSERT INTO modules (MODULE_NAME) VALUES (?)");
    $statement->execute([$nom]);
}

    header("Location: ./index.php");
?>