<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Bakery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Are you sure you want to delete this bakery?</h1>
    
    <?php 
    if (isset($_GET['bakeryID'])) {
        $getBakeryByID = getBakeryByID($pdo, $_GET['bakeryID']); 
        
        if ($getBakeryByID) {
            ?>
            <h2>Bakery Name: <?php echo ($getBakeryByID['bakeryName']); ?></h2>
            <h2>Bakery Address: <?php echo ($getBakeryByID['bakeryAddress']); ?></h2>
            <h2>Specialty: <?php echo ($getBakeryByID['specialty']); ?></h2>
            <h2>License Number: <?php echo ($getBakeryByID['b_license']); ?></h2>

            <form action="core/handleForms.php?bakeryID=<?php echo $_GET['bakeryID']; ?>" method="POST">
                <input type="submit" name="deleteBakeryBtn" value="Delete">
            </form>
            <?php
        } else {
            echo "<h2>Bakery not found.</h2>";
        }
    } else {
        echo "<h2>No bakery ID provided.</h2>";
    }
    ?>
</body>
</html>
