<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/alerts.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../css/home.css">
<link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/solid.css">
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>
    <section style="margin-top: 70px;">
        <div class="hello-text">
            <h1>Hello, <?php echo ($_SESSION["first_name"] . " " . $_SESSION["last_name"]) ?></h1>
            <h3>Here you will find all the tools you need !</h3>
        </div>
    </section>

    <script src="../../js/alerts.js"></script>
    <?php
    include("../../includes/scripts.php");
    ?>
</body>

</html>