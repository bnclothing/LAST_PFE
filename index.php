<!DOCTYPE html>
<?php
include("php/database.php");
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>ClassTalk</title>
    
</head>

<body>
    <div id="header">
        <a href="#" id="logo">
            <h2>ClassTalk<h2>
        </a>

        <div id="navbar" class="">
            <li><a class="active" href="#">Brief</a></li>

            <?php if (isset($_SESSION["login"]) && $_SESSION["login"] == 1) : ?>
                <li><a href="pages/home/">Home</a></li>
            <?php else : ?>
                <li><a href="pages/login/">Log in</a></li>
            <?php endif; ?>
        </div>
    </div>
    <h1 class="Header-logo" id="text">ClassTalk</h1>
    <div>
        <h2>Welcome to ClassTalk,</h2>
        <h3>
            your innovative platform for seamless communication and collaboration between teachers and students.<br>
            Experience the power of modern education technology, where learning meets interactivity. <br>
            Join us on a journey to enhance your educational experience and make learning more engaging and enjoyable!<br>
        </h3>
    </div>
    <script>
        var text = document.getElementById("text");
        setTimeout(() => {
            text.classList.add("text-animation");
            text.classList.remove("Header-logo");
        }, 1000);
    </script>

    <script src="./js/Settings.js"></script>

</body>

</html>