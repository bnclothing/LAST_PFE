<?php
include("../../php/database.php");
session_start();

$cmp = 0;
if ($_SESSION["login"] == 1) {
    $cmp = 1;
}
if ($cmp == 0) {
    header("location:../../");
}
?>

<div id="header">
    <a href="../home/" id="logo" style="color: white; ">
        <h2>ClassTalk<h2>
    </a>

    <div id="navbar" class="">
        <?php
        $currentUrl = $_SERVER['REQUEST_URI'];

        if ($_SESSION["name_role"] == "admin") {
            // Get the current URL

            $pages = array(
                "home" => "Home",
                "admin_users" => "Users",
                "admin_departments" => "Departments",
                "admin_fillieres" => "Fillieres",
                "admin_modules" => "Modules",
                "admin_groups" => "Chat Groups",
                "complaints" => "Complaints"
            );

            foreach ($pages as $page => $label) {
                // Construct the URL for the page
                $url = "../$page/";

                // Check if the current URL contains the page name
                $activeClass = (str_contains($currentUrl, $page)) ? "active" : "";

                // Output the navigation menu item
                echo '<li><a href="' . $url . '" class="' . $activeClass . '">' . $label . '</a></li>';
            }
        } else{
            $pages = array(
                "home" => "Home",
                "assignments" => "Assignments",
                "complaints" => "Complaints",
                "chat" => "Conversation",
            );
            
            foreach ($pages as $page => $label) {
                // Construct the URL for the page
                $url = "../$page/";
                if ($page == "chat") {
                    $url .= "?chat_type=all&group_id=1"; // Use .= for concatenation
                }
                // Check if the current URL contains the page name
                $activeClass = (str_contains($currentUrl, $page)) ? "active" : "";
            
                // Output the navigation menu item
                echo '<li><a href="' . $url . '" class="' . $activeClass . '">' . $label . '</a></li>';
            }
            
        }
        ?>


        <div class="dropdown">
            <li>
                <div id="profile-img" style="background-image: url('../../assets/images/<?php echo $_SESSION["image"]; ?>');" onclick="showMenu()"></div>
            </li>
            <div id="myDropdown" class="dropdown-content">
                <a href="../profile">My Profile</a>
                <a href="../Settings">Settings</a>
                <a class="exit_btn" href="../../php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>

    </div>
</div>