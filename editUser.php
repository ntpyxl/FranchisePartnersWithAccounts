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
        
        <?php $partnerData = getUserByID($pdo, $_GET['user_id']) ?>
        <form action="core/handleForms.php?user_id=<?php echo $_GET['user_id']; ?>" method="POST">
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $partnerData['first_name']; ?>">

            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $partnerData['last_name']; ?>"> <br>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="<?php echo $partnerData['age']; ?>">
            
            <label for="gender">Gender:</label>
            <select name="gender" id="first_name">
                <option value="Male" <?php echo ($partnerData['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($partnerData['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Gay" <?php echo ($partnerData['gender'] == 'Gay') ? 'selected' : ''; ?>>Gay</option>
                <option value="Lesbian" <?php echo ($partnerData['gender'] == 'Lesbian') ? 'selected' : ''; ?>>Lesbian</option>
                <option value="Transgender" <?php echo ($partnerData['gender'] == 'Transgender') ? 'selected' : ''; ?>>Transgender</option>
                <option value="Prefer Not To Say" <?php echo ($partnerData['gender'] == 'Prefer Not To Say') ? 'selected' : ''; ?>>Prefer Not To Say</option>
            </select>
            
            <label for="birthdate">Birthdate:</label>
            <input type="date" name="birthdate" id="birthdate" value="<?php echo $partnerData['birthdate']; ?>"> <br>
            
            <label for="home_address">Home Address:</label>
            <input type="text" name="home_address" id="home_address" value="<?php echo $partnerData['home_address']; ?>"> <br>

            <input type="submit" name="editUserButton" value="Apply changes">
        </form>

        <input type="submit" value="Cancel" onclick="window.location.href='index.php'">
    <body>
</html>