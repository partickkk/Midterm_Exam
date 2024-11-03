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
        h3 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
        h2 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h3>Welcome to the Bakery Management System</h3>
    <h2>Please Login to your account below!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo htmlspecialchars($_SESSION['message']); ?></h1>
    <?php unset($_SESSION['message']); } ?>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username: </label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="u_password">Password: </label>
            <input type="password" name="u_password" required>
        </p>
        <p>
            <input type="submit" name="loginBtn" value="Log in">
        </p>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php" style="text-decoration: none; color: blue;">Register</a></p>
        </div>
    </form>
</body>
</html>