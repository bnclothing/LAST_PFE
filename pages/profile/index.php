<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassTalk | Profile</title>
    <link rel="stylesheet" href="../../css/profile.css">
<link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/solid.css">
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>

    <div class="container" style="margin-top: 50px; cursor: none;">
        <div class="main-informations" id="mainInformations">

            <div class="image-container">
                <div class="image">
                    <div id="profile" style="background-image: url('../../assets/images/<?php echo $_SESSION["image"]; ?>');"></div>
                </div>
            </div>

            <div class="informations">
                <h1 class="name"> <?php echo ($_SESSION["first_name"] . " " . $_SESSION["last_name"]) ?></h1>
                <h1 class="email"> <?php echo ($_SESSION["email"]) ?></h1>
                <h2 class="role"> <?php echo ($_SESSION["name_role"]) ?></h2>
            </div>

            <div class="light" id="light"></div>
        </div>

        <?php 
        // Check if the user is not an admin
        if ($_SESSION["name_role"] != 'admin') {
            // Check if the user is a teacher
            if ($_SESSION["name_role"] == 'teacher') {
                // Display all departments associated with the teacher
                echo '<div class="ecole-informations">';
                echo '<div class="department" id="department">';
                echo '<h2 class="title">Departments</h2>';
                echo '<div class="informations-text">';
                foreach ($_SESSION["departments"] as $department) {
                    echo '<h3>' . $department . '</h3>';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="filliere" id="filliere">';
                echo '<h2 class="title">Fillieres</h2>';
                echo '<div class="informations-text">';
                foreach ($_SESSION["fillieres"] as $filliere) {
                    echo '<h3> ' . $filliere . '</h3>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            } else {
                // Display the department and filliere for students
                echo '<div class="ecole-informations">';
                echo '<div class="department" id="department">';
                echo '<h3 class="title">Department</h3>';
                echo '<h3>' . $_SESSION["department"] . '</h3>';
                echo '</div>';
                echo '<div class="filliere" id="filliere">';
                echo '<h3 class="title">Filliere</h3>';
                echo '<h3>' . $_SESSION["filliere"] . '</h3>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>

    </div>
    <div class="edit">
        <a href="../profile_edit"><i class="fa-regular fa-pen-to-square edit-btn"></i></a>
    </div>

    <?php
    include("../../includes/scripts.php");
    ?>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let mainInformations = document.getElementById('mainInformations');
            let light = document.getElementById('light');

            mainInformations.addEventListener('mouseenter', function() {
                light.style.display = 'block'; // Show the light effect
            });

            mainInformations.addEventListener('mousemove', function(e) {
                let left = e.pageX - mainInformations.offsetLeft; // Adjust for container offset
                let top = e.pageY - mainInformations.offsetTop; // Adjust for container offset
                light.style.left = left + 'px';
                light.style.top = top + 'px';
            });

            mainInformations.addEventListener('mouseleave', function() {
                light.style.display = 'none'; // Hide the light effect
            });
        });
    </script>

</body>

</html>
