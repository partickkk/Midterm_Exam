<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php $getProductByID = getProductByID($pdo, $_GET['productID']); ?>
    <h1>Are you sure you want to delete this Product?</h1>

    <h2>Product Name: <?php echo $getProductByID['productName'] ?></h2>
    <h2>Product Type: <?php echo $getProductByID['productType'] ?></h2>
    <h2>Price: <?php echo $getProductByID['price'] ?></h2>
    <h2>Expiry Date: <?php echo $getProductByID['p_expiryDate'] ?></h2>
    <h2>Date Added: <?php echo $getProductByID['date_added'] ?></h2>

    <form action="core/handleForms.php?productID=<?php echo $_GET['productID']; ?>&bakeryID=<?php echo $_GET['bakeryID']; ?>" method="POST">
        <input type="submit" name="deleteProductBtn" value="Delete">
    </form>
</body>
</html>
