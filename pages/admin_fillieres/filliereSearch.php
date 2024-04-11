<?php
include("../../php/database.php");

$searchBy = $_POST["searchBy"];
$search = $_POST["search"];

$statement = $db->prepare("SELECT * FROM fillieres f, departments d WHERE f.id_department = d.id_department AND $searchBy LIKE '%$search%'");
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $value) {
    foreach ($result as $value) {
        echo '<section class="row-fadeIn-wrapper">';
                    echo '<article class="row nfl">';
                    echo "<ul>";
                    echo "<li style=\"width: 75%;\">" . $value["FILLIERE_NAME"] . "</li>";
                    echo "<li style=\"width: 25%;\">
            <a href=?edit=" . $value["ID_FILLIERE"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
            &nbsp;
            &nbsp;
            &nbsp;
            <a href=?delete=" . $value["ID_FILLIERE"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
                  </li>";
                    echo "</ul>";
                    echo "</article>";
                    echo "</section>";
    }
}
