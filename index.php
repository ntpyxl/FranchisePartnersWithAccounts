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
        
        <input type="submit" value="Log out" onclick="window.location.href='core/logout.php'">
        <input type="submit" value="Franchise Logs" onclick="window.location.href='franchiseLogs.php'">

        <h3>Here are your franchises!</h3>
        <table>
            <tr>
                <th>Franchise ID</th>
                <th>Franchise Name</th>
                <th>Franchise Location</th>
                <th>Date Franchised</th>
                <th>Actions</th>
            </tr>

            <?php $partnerFranchisesData = getFranchisesByPartnerID($pdo, $_SESSION['user_id']); ?>
            <?php foreach ($partnerFranchisesData as $row) { ?>
            <tr>
                <td><?php echo $row['franchise_id']?></td>
                <td><?php echo $row['business_name']?></td>
                <td><?php echo $row['franchise_location']?></td>
                <td><?php echo $row['date_franchised']?></td>
                <td>
                    <?php
                        $franchise_id = $row['franchise_id'];
                        $user_id = $_SESSION['user_id'];
                    ?>
                    <input type="submit" value="Edit Franchise" onclick="window.location.href='editFranchise.php?franchise_id=<?php echo $franchise_id; ?>&user_id=<?php echo $user_id; ?>';">
                    <input type="submit" value="Remove Franchise" onclick="window.location.href='removeFranchise.php?franchise_id=<?php echo $franchise_id; ?>&user_id=<?php echo $user_id; ?>';">
                </td>
            </tr>
            <?php } ?>
        </table> <br>

        <input type="submit" value="Add Franchise" onclick="window.location.href='addFranchise.php?user_id=<?php echo $_SESSION['user_id']; ?>';">
        <input type="submit" value="View Other Partners and Franchises" onclick="window.location.href='viewOtherPartners.php'">

        <br><br><br>
        <h3>Your profile</h3>
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

            <?php $userData = getUserByID($pdo, $_SESSION['user_id']); ?>
            <tr>
                <td><?php echo $userData['user_id']?></td>
                <td><?php echo $userData['first_name']?></td>
                <td><?php echo $userData['last_name']?></td>
                <td><?php echo $userData['age']?></td>
                <td><?php echo $userData['gender']?></td>
                <td><?php echo $userData['birthdate']?></td>
                <td><?php echo $userData['home_address']?></td>
                <td><?php echo $userData['date_registered']?></td>
            </tr>
        </table>

        <input type="submit" value="Edit Profile" onclick="window.location.href='editUser.php?user_id=<?php echo $userData['user_id']; ?>';">
        <input type="submit" value="Delete Account" onclick="window.location.href='removeUser.php?user_id=<?php echo $userData['user_id']; ?>';">
    </body>
</html>