<?php
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if(!isset($_SESSION['bakeryID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
    <body>
    <h2>Welcome <?php echo $_SESSION['username']?> to Bakery Management System!</h2>

<input type="submit" value="Log out" onclick="window.location.href='core/logout.php'">
<input type="submit" value="Bakery Logs" onclick="window.location.href='bakerylogs.php'">

<h3>Here are your Products!</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Price</th>
            <th>Expiry Date</th>
            <th>Date Added</th>
            <th>Action</th>
        </tr>
        
        <?php $getProductsByBakery = getProductsByBakery($pdo, $_SESSION['bakeryID']); ?>
        <?php foreach ($getProductsByBakery as $row) { ?>
        <tr>
            <td><?php echo $row['productID']?></td>
            <td><?php echo $row['productName']?></td>
            <td><?php echo $row['productType']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['p_expiryDate']?></td>
            <td><?php echo $row['date_added']?></td>
            <td>
                <?php
                    $productID = $row['productID'];
                    $bakeryID = $_SESSION['bakeryID'];
                ?>
                <input type="submit" value="Edit Product" onclick="window.location.href='editproduct.php?productID=<?php echo $productID; ?>&bakeryID=<?php echo $bakeryID; ?>';">
                <input type="submit" value="Remove Product" onclick="window.location.href='deleteproduct.php?productID=<?php echo $productID; ?>&bakeryID=<?php echo $bakeryID; ?>';">
            </td>
        </tr>
        <?php } ?>
    </table> <br>

    <input type="submit" value="Add Product" onclick="window.location.href='viewproduct.php?bakeryID=<?php echo $_SESSION['bakeryID']; ?>';">

    <br><br><br>
    <h3>Your profile</h3>
    <table>
        <tr>
            <th>Owner ID</th>
            <th>Bakery Name</th>
            <th>Bakery Address</th>
            <th>Specialty</th>
            <th>Bakery License</th>
            <th>Date Added</th>
        </tr>

        <?php $userData = getBakeryByID($pdo, $_SESSION['bakeryID']); ?>
        <tr>
            <td><?php echo $userData[0]?></td>
            <td><?php echo $userData['bakeryName']?></td>
            <td><?php echo $userData['bakeryAddress']?></td>
            <td><?php echo $userData['specialty']?></td>
            <td><?php echo $userData['b_license']?></td>
            <td><?php echo $userData['date_added']?></td>
        </tr>
    </table>

    <input type="submit" value="Edit Profile" onclick="window.location.href='editbakery.php?bakeryID=<?php echo $userData['bakeryID']; ?>';">
        
    </body>
</html>
