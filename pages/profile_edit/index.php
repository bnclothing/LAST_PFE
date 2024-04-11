<!DOCTYPE html>
<html lang="en">
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassTalk | edit</title>
    <link rel="stylesheet" href="../../css/profile.css">
<link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/fontawesome.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/brands.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/solid.css">
</head>

<body>

<?php
    include("../../includes/help.php");
?>
    <div class="top">
        <button onclick="goBack()" id="goBack" class="button-29"><i class="fa-solid fa-arrow-left"></i></button>
    </div>
    <form>
        <div class="main-informations">
            <div class="image-container">
                <div class="image">
                    <div id="profile" style="background-image: url('../../assets/images/<?php echo ($_SESSION["image"]) ?>');"></div>
                </div>
            </div>
            <div class="informations">
                <table class="edit-informations">
                    <tr id="first-name-row">
                        <td>
                            <h2>First Name</h2>
                        </td>
                        <td><input autocomplete="off" type="text" id="first-name" value="<?php echo ($_SESSION["first_name"]) ?>"></td>
                    </tr>
                    <tr id="last-name-row">
                        <td>
                            <h2>Last Name</h2>
                        </td>
                        <td><input autocomplete="off" type="text" id="last-name" value="<?php echo ($_SESSION["last_name"]) ?>"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="buttons">
            <button class="button-29 btn green" type="submit">Done</button>
            <button class="button-29 btn red" type="reset">reset</button>
        </div>
    </form>


<script src="../../js/help.js"></script>
<script src="../../js/Settings.js"></script>




    <script>
        function goBack() {
            window.location.href = '../profile';
        }
    </script>



</body>

</html>