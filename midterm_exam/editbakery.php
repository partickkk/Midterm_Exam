<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bakery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    $getBakeryByID = getBakeryByID($pdo, $_GET['bakeryID']);
    
    if (!$getBakeryByID) {
        echo "<h2>Bakery not found!</h2>";
        exit;
    }
    ?>
    
    <h1>Edit the Bakery!</h1>
    <form action="core/handleForms.php?bakeryID=<?php echo $_GET['bakeryID']; ?>" method="POST">
        <p>
            <label for="bakeryName">Bakery Name: </label>
            <input type="text" name="bakeryName" value="<?php echo $getBakeryByID['bakeryName']; ?>" required>
        </p>
        <p>
            <label for="bakeryAddress">Bakery Address: </label>
            <input type="text" name="bakeryAddress" value="<?php echo $getBakeryByID['bakeryAddress']; ?>" required>
        </p>
        <p>
            <label for="specialty">Specialty: </label>
            <input type="text" name="specialty" value="<?php echo $getBakeryByID['specialty']; ?>" required>
        </p>
        <p>
            <label for="b_license">License Number: </label>
            <input type="number" name="b_license" value="<?php echo $getBakeryByID['b_license']; ?>" required>
        </p>
        <p><input type="submit" name="editBakeryBtn" value="Update Bakery"></p>
    </form>
    
    <p><a href="index.php">Return to Home Screen</a></p>
</body>
</html>
