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
        <h3>Are you sure you want to delete your account and your franchises? This action is irreversible.</h3> <br>

        <?php $partnerData = getUserByID($pdo, $_GET['user_id']) ?>
        <?php $partnerFranchisesData = getFranchisesByPartnerID($pdo, $_GET['user_id']); ?>
        <form action="core/handleForms.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
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
                </tr>
                <tr>
                    <td><?php echo $partnerData['user_id']?></td>
                    <td><?php echo $partnerData['first_name']?></td>
                    <td><?php echo $partnerData['last_name']?></td>
                    <td><?php echo $partnerData['age']?></td>
                    <td><?php echo $partnerData['gender']?></td>
                    <td><?php echo $partnerData['birthdate']?></td>
                    <td><?php echo $partnerData['home_address']?></td>
                    <td><?php echo $partnerData['date_registered']?></td>
                </tr>
                </table> <br>

                <table>
                <tr>
                    <th>Franchise ID</th>
                    <th>Franchise Name</th>
                    <th>Franchise Location</th>
                    <th>Date Franchised</th>
                </tr>

                <?php foreach ($partnerFranchisesData as $row) { ?>
                <tr>
                    <td><?php echo $row['franchise_id']?></td>
                    <td><?php echo $row['business_name']?></td>
                    <td><?php echo $row['franchise_location']?></td>
                    <td><?php echo $row['date_franchised']?></td>
                </tr>
                <?php } ?>
            </table>

            <input type="submit" name="removeUserButton" value="Remove">
        </form>

        <input type="submit" value="Cancel" onclick="window.location.href='index.php'">
    <body>
</html>