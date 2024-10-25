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
        <input type="submit" value="Return To Other Partners" onclick="window.location.href='viewOtherPartners.php'">

        <h3><?php echo getUserByID($pdo, $_GET['user_id'])['first_name'] ?>'s franchises:</h3>
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