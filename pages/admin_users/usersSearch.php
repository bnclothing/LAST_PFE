<?php
include("../../php/database.php");

$searchBy = $_POST["searchBy"];
$search = $_POST["search"];
$statement = $db->prepare("SELECT * FROM users u,roles r where r.id_Role=u.ROLE and name_role not like 'admin' and $searchBy LIKE '%$search%'");
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $value) {
    echo '<section class="row-fadeIn-wrapper">';
    echo '<article class="row nfl">';
    echo "<ul>";
    echo "<li >" . $value["FIRST_NAME"] . "</li>";
    echo "<li>" . $value["LAST_NAME"] . "</li>";
    echo "<li>" . $value["name_role"] . "</li>";
    echo "<li>" . $value["EMAIL"] . "</li>";
    echo "<li>" . $value["PASSWORD"] . "</li>";
    echo "<li>
<a href=?edit=" . $value["ID_USER"] . " ><span><i class='fa-solid fa-user-pen'></i></span></a>
&nbsp;
&nbsp;
&nbsp;
<a href=?delete=" . $value["ID_USER"] . " id='delete' ><span  ><i class='fa-solid fa-user-slash'></i></span></a>
      </li>";
    echo "</ul>";
    echo "</article>";
    echo "</section>";
}
