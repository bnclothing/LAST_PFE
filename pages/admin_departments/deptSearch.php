<?php
include("../../php/database.php");

$searchBy = $_POST["searchBy"];
$search = $_POST["search"];

$statement = $db->prepare("SELECT * FROM departments where $searchBy LIKE '%$search%'");
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $value) {
    foreach ($result as $value) {
        echo '<section class="row-fadeIn-wrapper">';
        echo '<article class="row nfl">';
        echo "<ul>";
        echo "<li style=\"width: 60%;\">" . $value["DEPARTMENT_NAME"] . "</li>";
        echo "<li style=\"width: 20%;\">" . $value["Department_code"] . "</li>";
        echo "<li style=\"width: 20%;\">
    <a href=?edit=" . $value["ID_DEPARTMENT"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
    &nbsp;
    &nbsp;
    &nbsp;
    <a href=?delete=" . $value["ID_DEPARTMENT"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
            </li>";
        echo "</ul>";
        echo "</article>";
        echo "</section>";
    }
}
