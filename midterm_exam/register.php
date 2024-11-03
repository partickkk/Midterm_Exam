<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        h2 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
        h3 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3></h3>
    <h2>Register your account below!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

    <form action="core/handleForms.php" method="POST">
        <p>
        <label for="username">Username</label>
        <input type="text" name="username" required>
        </p>
        <p>
        <label for="u_password">Password</label>
        <input type="password" name="u_password" required>
        </p>
        <p>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required>
        </p>
        <p>
            <label for="bakeryName">Bakery Name: </label>
            <input type="text" name="bakeryName" required>
        </p>
        <p>
            <label for="bakeryAddress">Address: </label>
            <input type="text" name="bakeryAddress" required>
        </p>
        <p>
            <label for="specialty">Specialty:</label>
            <select id="specialty" name="specialty">
                <option value="Cookie">Cookie</option>
                <option value="Pastries and Croissants">Pastries and Croissants</option>
                <option value="Cakes">Cakes</option>
                <option value="Desserts">Desserts</option>
                <option value="Bread">Bread</option>
            </select>
        </p>
        <p>
            <label for="b_license">Bakery License: </label>
            <input type="number" name="b_license" min="1" required>
        </p>

        <p>
            <input type="submit" name="registerBtn" value="Register Account">
        </p>
    </form>
        <p>
            <input type="submit" name="returnButton" value="Return to Login Page" onclick="window.location.href='login.php'">
        </p>
</body>
</html>