<?php require_once 'core/dbConfig.php' ?>
<?php require_once 'core/functions.php' ?>

<html>
    <head>
        <title>ntpyxl Franchising Partners</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2>Welcome to ntpyxl's Franchising Partners! Register your account below!</h2>

        <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

        <form action="core/handleForms.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" required> 
            
            <label for="confirm_password">Confirm password</label>
            <input type="password" name="confirm_password" required> <br><br>

            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" required> <br>

            <label for="age">Age</label>
            <input type="number" name="age" id="age" min="0" required>

            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Gay">Gay</option>
                <option value="Lesbian">Lesbian</option>
                <option value="Transgender">Transgender</option>
                <option value="Prefer Not To Say">Prefer Not To Say</option>
            </select>

            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" min="1970-01-01" max="2024-12-31" required> <br>

            <label for="home_address">Home Address</label>
            <input type="text" name="home_address" id="home_address" required> <br>

            <input type="submit" name="registerButton" value="Register account">
        </form>

            <input type="submit" name="returnButton" value="Return to login" onclick="window.location.href='login.php'">
    </body>
</html>