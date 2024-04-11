<?php
    $db = new PDO("mysql:host=localhost;dbname=pfe_2","root","");
    $db->query("SET NAMES 'utf8'");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>