<?php
require_once 'core/dbConfig.php';
require_once 'core/functions.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<html>
    <head>
        <title>ntpyxl Franchising Partners</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h3>Are you sure you want to remove this franchise?</h3>

        <?php $franchiseData = getFranchiseByID($pdo, $_GET['franchise_id']) ?>
        <form action="core/handleForms.php?franchise_id=<?php echo $_GET['franchise_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" method="POST">
            <table>
                <tr>
                    <th>Franchise ID</th>
                    <th>Franchise Name</th>
                    <th>Franchise Location</th>
                    <th>Date Franchised</th>
                </tr>
                <tr>
                    <td><?php echo $franchiseData['franchise_id']?></td>
                    <td><?php echo $franchiseData['business_name']?></td>
                    <td><?php echo $franchiseData['franchise_location']?></td>
                    <td><?php echo $franchiseData['date_franchised']?></td>
                </tr>
            </table>

            <input type="submit" name="removeFranchiseButton" value="Remove">
        </form>

        <input type="submit" value="Cancel" onclick="window.location.href='index.php'">
    <body>
</html>