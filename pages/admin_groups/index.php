<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Groups</title>
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

    <div class="container-as">
        <?php
        $sql = $db->prepare("SELECT gd.NAME AS GroupName, gdt.libelle_gc_type AS Type, gd.entity_type AS Entity FROM groupdiscussion gd JOIN groupdiscussiontype gdt ON gd.TYPE = gdt.id_gc_type ORDER BY gd.ID_GROUP_DISCUSSION");
        $sql->execute();
        $result = $sql->fetchAll();

        // Group discussions by GroupName
        $groupedDiscussions = [];
        foreach ($result as $value) {
            if (!isset($groupedDiscussions[$value['GroupName']])) {
                $groupedDiscussions[$value['GroupName']] = [
                    'GroupName' => $value['GroupName'],
                    'Types' => []
                ];
            }
            $groupedDiscussions[$value['GroupName']]['Types'][] = $value['Type'];
        }

        // Display grouped discussions
        foreach ($groupedDiscussions as $discussion) {
            echo '<div class="card">
            <div class="side1">
            ' . $discussion['GroupName'] . '
            </div>
            <div class="side2"> ';
            foreach ($discussion['Types'] as $type) {
                echo '<div class="type">' . $type . '</div>';
            }
            echo '</div>
        </div>';
        }
        ?>
        <div class="card">
            <i class="fa-solid fa-plus fa-2xl"></i>
        </div>
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