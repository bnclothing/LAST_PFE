<!DOCTYPE html>
<html lang="en">
<?php
include("../../php/database.php");
session_start();

if (isset($_POST["submit"])) {
    if (isset($_POST["complaint_id"]) && isset($_POST["respond"]) && isset($_POST["new_status"]))
        $complaint_id = $_POST["complaint_id"];
    $respond = $_POST["respond"];
    $new_status = $_POST["new_status"];

    $statement = $db->prepare("UPDATE `complaints` SET `Respond` = ?, `STATUS` = ? WHERE `ID_COMPLAINT` = ?");
    $statement->execute([$respond, $new_status, $complaint_id]);
    header("Location: ../complaints");
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/users.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../css/complaints.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
    <title>ClassTalk | Complaints</title>
</head>

<body>
    <?php
    include("../../includes/help.php");

    $ComplaintData = []; // Initialize $UserData to prevent potential errors
    if (isset($_GET['id'])) {
        $iduv = $_GET['id'];

        // Fetch the data of the file from the database
        $sql = $db->prepare("SELECT * FROM complaints where ID_COMPLAINT=?");
        $sql->execute([$iduv]);
        $ComplaintData = $sql->fetch(PDO::FETCH_ASSOC);

        //Get Type
        $Type;
        if (isset($ComplaintData['TYPE'])) {
            $sql = $db->prepare("SELECT type_labelle FROM complaint_type WHERE id_type=?");
            $sql->execute([$ComplaintData['TYPE']]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $Type = $result['type_labelle'];
            } else {
                $Type = "Unknown Type";
            }
        }

        //Get Status
        $Status;
        if (isset($ComplaintData['STATUS'])) {
            $sql = $db->prepare("SELECT status_labelle FROM complaint_status WHERE id_status=?");
            $sql->execute([$ComplaintData['STATUS']]);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $Status = $result['status_labelle'];
            } else {
                $Status = "Unknown Status";
            }
        }
    }


    ?>

    <div class="modal-content complaint-edit">
        <form action="index.php" method="POST" class="addUserForm" class="complaintModal">

            <input value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" type="number" name="complaint_id" id="complaint_id" hidden>

            <label for="complaint">Complaint:</label>
            <input value="<?php echo isset($ComplaintData['complaint']) ? htmlspecialchars($ComplaintData['complaint']) : ''; ?>" type="text" name="complaint" id="complaint" disabled>

            <label for="type">Type:</label>
            <input value="<?php echo $Type ?>" type="text" name="type" id="type" disabled>

            <label for="status">Status:</label>
            <input value="<?php echo $Status ?>" type="text" name="status" id="status" disabled>

            <label for="time">Time:</label>
            <input value="<?php echo isset($ComplaintData['time']) ? htmlspecialchars($ComplaintData['time']) : ''; ?>" type="text" name="time" id="time" disabled>

            <label for="user_id">User ID:</label>
            <input value="<?php echo isset($ComplaintData['ID_USER']) ? htmlspecialchars($ComplaintData['ID_USER']) : ''; ?>" type="text" name="user_id" id="user_id" disabled>

            <!--this part of code hande the change of fields between admin and other users -->
            <?php
            if ($_SESSION["name_role"] == "admin") {
                echo '<label for="new_status">New Status:</label>
        <select name="new_status" id="new_status">
            <option value="1">Compleated</option>
            <option value="2">Under Review</option>
        </select>
        <label for="respond">Respond:</label>
        <input value="" type="text" name="respond" id="respond" required height="20px">
        
        <div class="form-buttons">
            <input type="submit" value="Respond" name="submit">
            &nbsp;&nbsp;&nbsp;
            <input type="reset" value="Annuler" name="reset" onclick="BackToPage()">
        </div>';
            } else {
                echo '<label for="respond">Respond:</label>
        <input value="' . (isset($ComplaintData['Respond']) ? htmlspecialchars($ComplaintData['Respond']) : '') . '" type="text" name="respond" id="respond" disabled height="20px">
        
        <div class="form-buttons">
            <input type="reset" value="Close" name="reset" onclick="BackToPage()">
        </div>
    ';
            }
            ?>

        </form>

    </div>

    <script>
        function BackToPage() {
            window.location.href = "../complaints";
        }
    </script>
    <script src="../../js/help.js"></script>
    <script src="../../js/Settings.js"></script>


</body>

</html>