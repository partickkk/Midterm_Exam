<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="viewproduct.php?bakeryID=<?php echo $_GET['bakeryID']; ?>">View the Products</a>
    <h1>Edit the Product!</h1>
    
    <?php 
    if (isset($_GET['productID'])) {
        $getProductByID = getProductByID($pdo, $_GET['productID']);
        
        if ($getProductByID) { 
    ?>
        <form action="core/handleForms.php?productID=<?php echo $_GET['productID']; ?>&bakeryID=<?php echo $_GET['bakeryID']; ?>" method="POST">
            <p>
                <label for="productName"> Product Name </label>
                <input type="text" name="productName" value="<?php echo ($getProductByID['productName']); ?>" required>
            </p>
            <p>
                <label for="productType"> Product Type </label>
                <input type="text" name="productType" value="<?php echo ($getProductByID['productType']); ?>" required>
            </p>
            <p>
                <label for="price"> Price </label>
                <input type="number" name="price" step="0.01" min="1" value="<?php echo ($getProductByID['price']); ?>" required>
            </p>
            <p>
                <label for="p_expiryDate"> Expiry Date </label>
                <input type="date" name="p_expiryDate" value="<?php echo ($getProductByID['p_expiryDate']); ?>" required>
            </p>
            <p>
                <input type="submit" name="editProductBtn" value="Update Product">
            </p>
        </form>
    <?php 
        } else {
            echo "<p>Product not found.</p>";
        }
    } else {
        echo "<p>No product ID provided.</p>";
    }
    ?>
    
    <p><a href="viewproduct.php?bakeryID=<?php echo $_GET['bakeryID']; ?>">Return to Products</a></p>
</body>
</html>



