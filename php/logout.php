<?php
include_once "database.php";
session_start();

// Clear session variables and destroy the session
unset($_SESSION["sections"]);
unset($_SESSION["type_user"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);

session_destroy();
header("Location: ../");
exit;
?>
