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
        <h2>Welcome <?php echo getUserByID($pdo, $_SESSION['user_id'])['first_name'] ?> to ntpyxl's Franchising Partners!</h2>

        <input type="submit" value="Return To Your Franchises" onclick="window.location.href='index.php'">

        <h3>Here are our other partners and their franchises!</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Home Address</th>
                <th>Date Registered</th>
                <th>Actions</th>
            </tr>

            <?php $allPartnersData = getAllPartnersExceptID($pdo, $_SESSION['user_id']); ?>
            <?php foreach ($allPartnersData as $row) { ?>
            <tr>
                <td><?php echo $row['user_id']?></td>
                <td><?php echo $row['first_name']?></td>
                <td><?php echo $row['last_name']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['gender']?></td>
                <td><?php echo $row['birthdate']?></td>
                <td><?php echo $row['home_address']?></td>
                <td><?php echo $row['date_registered']?></td>
                <td style="max-width: 350px;">
                    <input type="submit" value="View Franchises" onclick="window.location.href='viewOtherFranchises.php?user_id=<?php echo $row['user_id']; ?>';">
                </td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>