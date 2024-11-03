<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php">Return to Home Screen</a>

    <?php 
        
        if (isset($_GET['bakeryID'])) {
            
            $getAllInfoByBakeryID = getBakeryByID($pdo, $_GET['bakeryID']);
            
            
            if ($getAllInfoByBakeryID) {
    ?>
                <h1>Bakery ID: <?php echo ($getAllInfoByBakeryID['bakeryID']); ?></h1>

                <h1>Add New Products</h1>
                <form action="core/handleForms.php?bakeryID=<?php echo $_GET['bakeryID']; ?>" method="POST">
                    <p>
                        <label for="productName">Product Name: </label>
                        <input type="text" name="productName"> 
                    </p>
                    <p>
                        <label for="productType">Product Type: </label>
                        <input type="text" name="productType">
                    </p>
                    <p>
                        <label for="price">Price: </label>
                        <input type="number" name="price" min = "1">
                    </p>
                    <p>
                        <label for="p_expiryDate">Expiry Date: </label>
                        <input type="date" name="p_expiryDate">
                    </p>
                    <p>
                        <input type="submit" name="insertProductBtn" value="Add Product">
                    </p>
                </form>

                <table style="width:100%; margin-top: 50px;">
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Type</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>

                    <?php 
                        
                        $getProductsByBakery = getProductsByBakery($pdo, $_GET['bakeryID']); 
                        foreach ($getProductsByBakery as $row) { 
                    ?>
                        <tr>
                            <td><?php echo ($row['productID']); ?></td>
                            <td><?php echo ($row['productName']); ?></td>
                            <td><?php echo ($row['productType']); ?></td>
                            <td><?php echo ($row['price']); ?></td>
                            <td><?php echo ($row['p_expiryDate']); ?></td>
                            <td><?php echo ($row['date_added']); ?></td>
                            <td>
                                <a href="editproduct.php?productID=<?php echo $row['productID']; ?>&bakeryID=<?php echo $_GET['bakeryID']; ?>">Edit</a>
                                <a href="deleteproduct.php?productID=<?php echo $row['productID']; ?>&bakeryID=<?php echo $_GET['bakeryID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
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
