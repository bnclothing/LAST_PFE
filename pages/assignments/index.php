<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/help.css">
    <link rel="stylesheet" href="../../css/assignments.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.5.1-web/css/all.css">
</head>

<body>
    <?php
    include("../../includes/navbar.php");
    include("../../includes/help.php");
    ?>

    <div class="container-as" id="assignments-container">

        <?php
        $sql = $db->prepare("SELECT assignment.*, CONCAT(users.FIRST_NAME, ' ', users.LAST_NAME) AS TEACHER_NAME
        FROM assignment
        JOIN users ON assignment.ID_TEACHER = users.ID_USER
        ORDER BY assignment.ID_TEACHER");
        $sql->execute();
        $result = $sql->fetchAll();

        $currentTeacher = null;

        foreach ($result as $assignment) {
            // Check if the teacher has changed
            if ($currentTeacher !== $assignment['ID_TEACHER']) {
                // Close the previous card if it exists
                if ($currentTeacher !== null) {
                    echo '</div>'; // Close the type div
                    echo '</div>'; // Close the assignment-card div
                }
                // Start a new card for the new teacher
                echo '<div class="card assignment-card">';
                echo '<div class="side1">' . $assignment['TEACHER_NAME'] . '</div>';
                echo '<div class="side2">'; // Open the side2 div
                $currentTeacher = $assignment['ID_TEACHER'];
            }
            // Display the assignment title
            echo '<div class="type">' . $assignment['TITLE'] . '</div>';
        }

        // Close the last card
        if ($currentTeacher !== null) {
            echo '</div>'; // Close the type div
            echo '</div>'; // Close the assignment-card div
        }
        ?>


    </div>

    <script>
        // Calculate and set the height of each .type element based on the number of elements
        document.querySelectorAll('.side2').forEach(typeContainer => {
            const typeElements = typeContainer.querySelectorAll('.type');
            const numTypeElements = typeElements.length;

            // Calculate the height based on the number of elements
            const heightPercentage = 100 / numTypeElements;
            typeElements.forEach(element => {
                element.style.height = `${heightPercentage}%`; // Subtract padding/margin to avoid overflow
            });
        });
    </script>

    <?php
    include("../../includes/scripts.php");
    ?>
</body>

</html>