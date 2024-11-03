<?php

// Insert a new bakery
function insertBakery($pdo, $bakeryName, $bakeryAddress, $specialty, $b_license) {
    $sql = "INSERT INTO bakery_shop (bakeryName, bakeryAddress, specialty, b_license) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$bakeryName, $bakeryAddress, $specialty, $b_license]);
    return $executeQuery;
}

// Update an existing bakery
function updateBakery($pdo, $bakeryName, $bakeryAddress, $specialty, $b_license, $bakeryID) {
    $sql = "UPDATE bakery_shop
            SET bakeryName = ?, bakeryAddress = ?, specialty = ?, b_license = ?
            WHERE bakeryID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$bakeryName, $bakeryAddress, $specialty, $b_license, $bakeryID]);

    return $executeQuery;
}

// Delete a bakery
function deleteBakery($pdo, $bakeryID) {
    // First, delete all products related to the bakery
    $deleteProductsSQL = "DELETE FROM product WHERE bakeryID = ?";
    $deleteStmt = $pdo->prepare($deleteProductsSQL);
    $executeDeleteProductsQuery = $deleteStmt->execute([$bakeryID]);

    if ($executeDeleteProductsQuery) {
        // Then, delete the bakery
        $sql = "DELETE FROM bakery_shop WHERE bakeryID = ?";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$bakeryID]);
        return $executeQuery;
    }
    return false;
}

// Get all bakeries
function getAllBakeries($pdo) {
    $sql = "SELECT * FROM bakery_shop";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Get a bakery by ID
function getBakeryByID($pdo, $bakeryID) {
    $sql = "SELECT * FROM bakery_shop WHERE bakeryID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bakeryID]);
    return $stmt->fetch();
}


function getProductsByBakery($pdo, $bakeryID) {
    $sql = "SELECT product.productID, product.productName, product.productType, product.price, product.p_expiryDate, product.date_added,
                   bakery_shop.bakeryName AS Bakery_Owner
            FROM product
            JOIN bakery_shop ON product.bakeryID = bakery_shop.bakeryID
            WHERE product.bakeryID = ?
            ORDER BY product.productName";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bakeryID]);
    return $stmt->fetchAll();
}


function insertProduct($pdo, $productName, $productType, $price, $p_expiryDate, $bakeryID) {
    $sql = "INSERT INTO product (productName, productType, price, p_expiryDate, bakeryID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$productName, $productType, $price, $p_expiryDate, $bakeryID]);

    if($executeQuery) {
        $productID = getNewestProductID($pdo)['productID'];
        $productData = getProductByID($pdo, $productID);
        logBakeryAction($pdo, "PRODUCT ADDED", $productData['bakeryID'], $productID, $_SESSION['bakeryID']);
        return true;
    }
}



function getProductByID($pdo, $productID) {
    $sql = "SELECT product.productID, product.productName, product.productType, product.price, product.p_expiryDate, product.date_added,
                   bakery_shop.bakeryName AS Bakery_Owner
            FROM product
            JOIN bakery_shop ON product.bakeryID = bakery_shop.bakeryID
            WHERE product.productID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productID]);

    return $stmt->fetch();
}


function updateProduct($pdo, $productName, $productType, $price, $p_expiryDate, $productID) {

    $productData = getProductByID($pdo, $productID);
    $sql = "UPDATE product
            SET productName = ?, productType = ?, price = ?, p_expiryDate = ?
            WHERE productID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$productName, $productType, $price, $p_expiryDate, $productID]);

    if($executeQuery) {
        logBakeryAction($pdo, "UPDATED PRODUCT", $productData['bakeryID'], $productID, $_SESSION['bakeryID']);
        return true;
    }
}


// Delete a product
function deleteProduct($pdo, $productID) {
    $productData = getProductByID($pdo, $productID);

    $sql = "DELETE FROM product WHERE productID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$productID]);

    if($executeQuery) {
        logBakeryAction($pdo, "DELETED PRODUCT", $productData['bakeryID'], $productID, $_SESSION['bakeryID']);
        return true;
    }
}


function loginUser($pdo, $username, $password) {
    if(!checkUsernameExistence($pdo, $username)) {
        return "usernameDoesntExist";
    }

    $query = "SELECT * FROM owner_account WHERE username = ?";
    $statement = $pdo -> prepare($query);
    $statement -> execute([$username]);
    $userAccInfo = $statement -> fetch();

    if(password_verify($password, $userAccInfo['u_password'])) {
        $_SESSION['bakeryID'] = $userAccInfo['ownerID'];
        $_SESSION['username'] = $userAccInfo['username'];
        return "loginSuccess";
    } else {
        return "incorrectPassword";
    }
}


function checkUsernameExistence($pdo, $username) {
    $query = "SELECT * FROM owner_account WHERE username = ?";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$username]);

    return $statement->rowCount() > 0;
}

function checkUserExistence($pdo, $bakeryName, $bakeryAddress, $specialty, $b_license) {
	$query = "SELECT * FROM bakery_shop
				WHERE bakeryName = ? AND 
				bakeryAddress = ? AND
				specialty = ? AND
				b_license= ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$bakeryName, $bakeryAddress, $specialty, $b_license]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function registerUser($pdo, $username, $u_password, $hashed_password, $confirm_password) {
    if (checkUsernameExistence($pdo, $username)) {
        return "UsernameAlreadyExists";
    }
    if ($u_password != $confirm_password) {
        return "PasswordNotMatch";
    }
    if (!validatePassword($u_password)) {
        return "InvalidPassword";
    }

    $query1 = "INSERT INTO owner_account (username, u_password) VALUES (?, ?)";
    $statement1 = $pdo->prepare($query1);
    $executeQuery1 = $statement1->execute([$username, $hashed_password]);

    if ($executeQuery1) {
        return "registrationSuccess";
    }
}

function getBakeryLogs ($pdo) {
    $query = "SELECT * FROM bakery_logs ORDER BY date_logged ASC";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute();

    if ($executeQuery) {
        return $statement->fetchAll();
    }
}

function logBakeryAction($pdo, $logsDescription, $bakeryID, $productID, $doneBy) {
    $query = "INSERT INTO bakery_logs (logs_description, bakeryID, productID, doneBy) VALUES (?, ?, ?, ?)";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute([$logsDescription, $bakeryID, $productID, $doneBy]);

    return $executeQuery;
}

function getNewestProductID($pdo) {
    $query = "SELECT productID FROM product ORDER BY productID DESC LIMIT 1;";
    $statement = $pdo->prepare($query);
    $executeQuery = $statement->execute();

    if ($executeQuery) {
        return $statement->fetch();
    }
}

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

function validatePassword($u_password) {
    if (strlen($u_password) >= 8) {
        $hasLower = $hasUpper = $hasNumber = false;

        for ($i = 0; $i < strlen($u_password); $i++) {
            if (ctype_lower($u_password[$i])) {
                $hasLower = true;
            }
            if (ctype_upper($u_password[$i])) {
                $hasUpper = true;
            }
            if (ctype_digit($u_password[$i])) {
                $hasNumber = true;
            }

            if ($hasLower && $hasUpper && $hasNumber) {
                return true;
            }
        }
    }
    return false;
}

function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}
