<!DOCTYPE html>
<html lang="en">

<?php
include("../../php/database.php");
session_start();

if (isset($_SESSION["login"]) && $_SESSION["login"] == 1) {
    header("location:../home");
    exit(); // Ensure that the script stops executing after the redirection
}


//!Login 
if (isset($_POST["connect"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $requete = $db->prepare("SELECT count(*) as count from users where email=? and password=?");
    $requete->bindValue(1, $email);
    $requete->bindValue(2, $password);
    $requete->execute();
    $login = $requete->fetch(PDO::FETCH_ASSOC);

    // Check if email and password are correct
    if ($login['count'] == 1) {

        // Proceed with the complete query to fetch user details
        $requete = $db->prepare("SELECT r.name_role, u.id_user, u.last_name, u.first_name, u.email, u.image, f.filliere_name, d.DEPARTMENT_NAME 
FROM users u 
INNER JOIN roles r ON u.role = r.id_role 
LEFT JOIN users_fillieres_assoc a ON u.id_user = a.user_id 
LEFT JOIN fillieres f ON a.filliere_id = f.id_filliere 
LEFT JOIN departments d ON f.ID_DEPARTMENT = d.ID_DEPARTMENT 
WHERE u.email = ?");
        $requete->bindValue(1, $email);
        $requete->execute();
        $userData = $requete->fetch(PDO::FETCH_ASSOC);

        // Store user details in session
        $_SESSION["name_role"] = $userData["name_role"];
        $_SESSION["id_user"] = $userData["id_user"];
        $_SESSION["last_name"] = $userData["last_name"];
        $_SESSION["first_name"] = $userData["first_name"];
        $_SESSION["email"] = $userData["email"];
        $_SESSION["image"] = $userData["image"];

        // Check if the user is a teacher
        if ($userData["name_role"] == "teacher") {
            // If teacher, fetch all fillieres and departments associated and store them in arrays
            $fillieres = [];
            $departments = [];
            $requete = $db->prepare("SELECT f.filliere_name, d.DEPARTMENT_NAME FROM users u 
    INNER JOIN users_fillieres_assoc a ON u.id_user = a.user_id 
    INNER JOIN fillieres f ON a.filliere_id = f.id_filliere 
    LEFT JOIN departments d ON f.ID_DEPARTMENT = d.ID_DEPARTMENT 
    WHERE u.id_user = ?");
            $requete->bindValue(1, $userData["id_user"]);
            $requete->execute();
            while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $fillieres[] = $row["filliere_name"];
                if (!in_array($row["DEPARTMENT_NAME"], $departments) && $row["DEPARTMENT_NAME"] !== null) {
                    $departments[] = $row["DEPARTMENT_NAME"];
                }
            }
            $_SESSION["fillieres"] = $fillieres;
            $_SESSION["departments"] = $departments;
        } else {
            // If not a teacher, just fetch and store the filliere and department associated
            $_SESSION["filliere"] = $userData["filliere_name"];
            $_SESSION["department"] = $userData["DEPARTMENT_NAME"];
        }

        // Set login session variable
        $_SESSION["login"] = 1;
        header("Location:../home");
        exit(); // Ensure script stops execution after redirection
    } else {

        echo '<div class="alert danger-alert">
                    <h3>Password or Email is incorrect</h3>
                </div>';
    }
}


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/alerts.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
    <title>Login Screen</title>
    <style>
        input[type="submit"] {
            border-radius: 20px;
            border: 1px solid #1e2434;
            background-color: #1e2434;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in, background-color .5s, color .5s;
        }

        input[type="submit"]:active {
            transform: scale(0.95);
        }

        input[type="submit"]:focus {
            outline: none;
            background-color: #FFFFFF;
            color: #1e2434;
        }

        input[type="submit"]:hover {
            cursor: pointer;
            background-color: #FFFFFF;
            color: #1e2434;
        }
    </style>
</head>

<body>
    <div id="header">
        <a href="#" id="logo" style="color: white; ">
            <h2>ClassTalk<h2>
        </a>

        <div id="navbar" class="">
            <li><a href="../../">Home</a></li>
            <li><a class="active" href="#">Log in</a></li>
        </div>
    </div>

    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="" method="post">
                <h1 style="color: #000;">Login in</h1>
                <br><br>
                <input autocomplete="off" type="email" name="email" placeholder="Email" />
                <input autocomplete="off" type="password" name="password" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <input autocomplete="off" type="submit" value="Login In" name="connect">
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("../../includes/help.php");
    ?>
    <script src="../../js/alerts.js"></script>
    <script src="../../js/help.js"></script>
    <script src="../../js/Settings.js"></script>


</body>

</html>