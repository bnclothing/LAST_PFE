<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/users.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../css/complaints.css">
<link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/solid.css">    <title>ClassTalk | Complaints</title>
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>

    <section class="wrapper">
        <!-- Row title -->
        <main class="row title">
            <ul>
                <li>Message</li>
                <li>Submited by</li>
                <li>Submitted at</li>
                <li>Type</li>
                <li>Status</li>
                <li>Operations</li>
            </ul>
        </main>
        <!-- Row 1 - fadeIn -->
        <div class="wrapperV2">
            <?php
            $sql;
            if ($_SESSION["name_role"] == "admin") {
                $sql = $db->prepare("SELECT * FROM complaints c,complaint_status s,complaint_type t,users u where c.TYPE=t.id_type and c.STATUS=s.id_status and c.ID_USER=u.ID_USER");
            } else {
                $sql = $db->prepare("SELECT * FROM complaints c,complaint_status s,complaint_type t,users u where c.TYPE=t.id_type and c.STATUS=s.id_status and c.ID_USER=u.ID_USER and c.ID_USER=" . $_SESSION["id_user"]);
            }
            $sql->execute();
            $result = $sql->fetchAll();
            foreach ($result as $value) {
                echo '<section class="row-fadeIn-wrapper">';
                echo '<article class="row nfl">';
                echo "<ul>";
                echo "<li>" . $value["complaint"] . "</li>";
                echo "<li>" . $value["EMAIL"] . "</li>";
                echo "<li>" . $value["time"] . "</li>";
                echo "<li>" . $value["type_labelle"] . "</li>";
                echo "<li>" . $value["status_labelle"] . "</li>";
                echo "<li>";
                echo "<a href=../complaint/?id=" . $value["ID_COMPLAINT"] . "><span><i class='fa-regular fa-folder-open'></i></span></a>";
                echo "</li>";
                echo "</ul>";
                echo "</article>";
                echo "</section>";
            }
            ?>
        </div>
    </section>

    <?php
    include("../../includes/scripts.php");
    ?>
</body>

</html>