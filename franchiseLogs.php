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
        <h2>Franchise Logs</h2>

        <input type="submit" value="Return To Your Profile" onclick="window.location.href='index.php'">

        <table>
            <tr>
                <th>Log ID</th>
                <th>Log Description</th>
                <th>Franchise ID</th>
                <th>Owner ID</th>
                <th>Action Done By</th>
                <th>Date Logged</th>
            </tr>

            <?php $franchiseLogs = getFranchiseLogs($pdo); ?>
            <?php foreach ($franchiseLogs as $row) { ?>
            <tr>
                <td><?php echo $row['log_id']?></td>
                <td><?php echo $row['log_desc']?></td>
                <td><?php echo $row['franchise_id']?></td>
                <td><?php echo $row['owner_id']?></td>
                <td><?php echo $row['done_by']?></td>
                <td><?php echo $row['date_logged']?></td>
            </tr>
            <?php } ?>
        </table>    
    </body>
</html>