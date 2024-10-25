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
        <h3>Please edit the according values as you intend.</h3>

        <?php $PartnerIDData = getUserByID($pdo, $_GET['user_id']); ?>
        <b>Currently viewing:</b> <br>
        <b>User ID:</b> <?php echo $PartnerIDData['user_id']; ?> <br>
        <b>Partner Name:</b> <?php echo $PartnerIDData['first_name'] . ' ' . $PartnerIDData['last_name']; ?> <br><br>

        <?php $franchiseData = getFranchiseByID($pdo, $_GET['franchise_id']); ?>

        <form action="core/handleForms.php?franchise_id=<?php echo $_GET['franchise_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" method="POST">
            <label for="business_name">Name:</label>
            <input type="text" name="business_name" id="business_name" value="<?php echo $franchiseData['business_name']; ?>"> <br>

            <label for="franchise_location">Location:</label>
            <input type="text" name="franchise_location" id="franchise_location" value="<?php echo $franchiseData['franchise_location']; ?>"> <br>
            
            <input type="submit" name="editFranchiseButton" value="Apply changes">
        </form>

        <input type="submit" value="Cancel" onclick="window.location.href='index.php'">
    <body>
</html>