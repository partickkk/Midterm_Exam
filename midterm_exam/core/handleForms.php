<?php
require_once 'dbConfig.php';
require_once 'models.php';


// Edit an existing bakery
if (isset($_POST['editBakeryBtn'])) {
    $query = updateBakery($pdo, $_POST['bakeryName'], $_POST['bakeryAddress'], $_POST['specialty'], $_POST['b_license'], $_GET['bakeryID']);

    if ($query) {
        header("Location: ../index.php");
        exit(); // Always use exit after header redirection
    } else {
        echo "Edit Failed";
    }
}

// Delete a bakery
if (isset($_POST['deleteBakeryBtn'])) {
    $query = deleteBakery($pdo, $_GET['bakeryID']);

    if ($query) {
        header("Location: ../index.php");
        exit(); // Always use exit after header redirection
    } else {
        echo "Deletion Failed";
    }
}

// Insert a new product
if (isset($_POST['insertProductBtn'])) {
    $query = insertProduct($pdo, $_POST['productName'], $_POST['productType'], $_POST['price'], $_POST['p_expiryDate'], $_GET['bakeryID']);

    if ($query) {
        header("Location: ../viewproduct.php?bakeryID=" . $_GET['bakeryID']);
        exit(); // Always use exit after header redirection
    } else {
        echo "Insertion Failed";
    }
}

// Edit an existing product
if (isset($_POST['editProductBtn'])) {
    // Check if productID is provided
    if (isset($_GET['productID'])) {
        $query = updateProduct($pdo, $_POST['productName'], $_POST['productType'], $_POST['price'], $_POST['p_expiryDate'], $_GET['productID']);

        if ($query) {
            header("Location: ../viewproduct.php?bakeryID=" . $_GET['bakeryID']);
            exit(); // Always use exit after header redirection
        } else {
            echo "Update Failed";
        }
    } else {
        echo "No product ID provided.";
    }
}

// Delete a product
if (isset($_POST['deleteProductBtn'])) {
    $query = deleteProduct($pdo, $_GET['productID']);

    if ($query) {
        header("Location: ../viewproduct.php?bakeryID=" . $_GET['bakeryID']);
        exit(); // Always use exit after header redirection
    } else {
        echo "Deletion Failed";
    }
}


if (isset($_POST['loginBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $u_password = $_POST['u_password'];

    // Call the login function from models
    $loginStatus = loginUser($pdo, $username, $u_password);

    switch ($loginStatus) {
        case "loginSuccess":
            redirectWithMessage('../index.php', '');
            break;
        case "usernameDoesNotExist":
            redirectWithMessage('../login.php', 'Username does not exist!');
            break;
        case "incorrectPassword":
            header("Location: ../login.php");
            exit(); // Prevent further execution
        default:
            redirectWithMessage('../login.php', 'User does not exist. Please REGISTER!');
            break;
    }
}

if (isset($_POST['registerBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $u_password = $_POST['u_password'];
    $hashed_password = password_hash($_POST['u_password'], PASSWORD_DEFAULT);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $bakeryName = sanitizeInput($_POST['bakeryName']);
    $bakeryAddress = sanitizeInput($_POST['bakeryAddress']);
    $specialty = $_POST['specialty'];
    $b_license = $_POST['b_license'];

    // Only username and password are used in the owner_account table
    $function = registerUser($pdo, $username, $u_password, $hashed_password, $confirm_password);
    
    if ($function == "registrationSuccess") {
        $query = insertBakery($pdo, $_POST['bakeryName'], $_POST['bakeryAddress'], $_POST['specialty'], $_POST['b_license']);
        header("Location: ../login.php");
    } elseif ($function == "UsernameAlreadyExists") {
        $_SESSION['message'] = "Username already exists! Please choose a different username!";
        header("Location: ../register.php");
    } elseif ($function == "PasswordNotMatch") {
        $_SESSION['message'] = "Password does not match!";
        header("Location: ../register.php");
    } elseif ($function == "InvalidPassword") {
        $_SESSION['message'] = "Password is not strong enough! Make sure it is 8 characters long, has uppercase and lowercase characters, and includes numbers.";
        header("Location: ../register.php");
    } else {
        echo "<h2>User addition failed.</h2>";
        echo '<a href="../register.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to register page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    } 

}

