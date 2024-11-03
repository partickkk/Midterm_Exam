<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if(!isset($_SESSION['bakeryID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<html>
    <head>
        <title>Bakery Management System</title>
        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2>Bakery Logs</h2>

        <input type="submit" value="Return To Your Profile" onclick="window.location.href='index.php'">

        <table>
            <tr>
                <th>Log ID</th>
                <th>Action Done</th>
                <th>Product ID</th>
                <th>Done By</th>
                <th>Date Logged</th>
            </tr>

            <?php $BakeryLogs = getBakeryLogs($pdo); ?>
            <?php foreach ($BakeryLogs as $row) { ?>
            <tr>
                <td><?php echo $row['logs_id']?></td>
                <td><?php echo $row['logs_description']?></td>
                <td><?php echo $row['productID']?></td>
                <td><?php echo $row['doneBy']?></td>
                <td><?php echo $row['date_logged']?></td>
            </tr>
            <?php } ?>
        </table>    
    </body>
</html>
