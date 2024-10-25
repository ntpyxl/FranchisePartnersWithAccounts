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
        <input type="submit" value="Return To Your Franchises" onclick="window.location.href='index.php'">

        <h3>Add your new franchise, <?php echo getUserByID($pdo, $_SESSION['user_id'])['first_name'] ?>:</h3>
        <form action="core/handleForms.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
            <label for="business_name">Name</label>
            <input type="text" name="business_name" id="business_name" required> <br>

            <label for="franchise_location">Location</label>
            <input type="text" name="franchise_location" id="franchise_location" required> <br>

            <input type="submit" name="addFranchiseButton" value="Add franchise">
        </form> <br>

        <h3>Your franchises:</h3>
        <table>
            <tr>
                <th>Franchise ID</th>
                <th>Franchise Name</th>
                <th>Franchise Location</th>
                <th>Date Franchised</th>
            </tr>

            <?php $partnerFranchisesData = getFranchisesByPartnerID($pdo, $_GET['user_id']); ?>
            <?php foreach ($partnerFranchisesData as $row) { ?>
            <tr>
                <td><?php echo $row['franchise_id']?></td>
                <td><?php echo $row['business_name']?></td>
                <td><?php echo $row['franchise_location']?></td>
                <td><?php echo $row['date_franchised']?></td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>