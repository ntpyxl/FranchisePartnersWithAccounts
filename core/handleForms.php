<?php
require_once 'dbConfig.php';
require_once 'functions.php';

if(isset($_POST['registerButton'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $home_address = sanitizeInput($_POST['home_address']);

    $function = addUser($pdo, $username, $password, $hashed_password, $confirm_password, $first_name, $last_name, $age, $gender, $birthdate, $home_address);
    if($function == "registrationSuccess") {
        header("Location: ../login.php");
    } elseif($function == "UsernameAlreadyExists") {
        $_SESSION['message'] = "Username already exists! Please choose a different username!";
        header("Location: ../register.php");
    } elseif($function == "UserAlreadyExists") {
        $_SESSION['message'] = "User already exists! Please edit your existing account instead!";
        header("Location: ../register.php");
    } elseif($function == "PasswordNotMatch") {
        $_SESSION['message'] = "Password does not match!";
        header("Location: ../register.php");
    } elseif($function == "InvalidPassword") {
        $_SESSION['message'] = "Password is not strong enough! Make sure it is 8 letters long, has uppercase and lowercase characters, and numbers.";
        header("Location: ../register.php");
    } else {
        echo "<h2>User addition failed.</h2>";
        echo '<a href="../register.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to register page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    } 
}

if(isset($_POST['loginButton'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    $function = loginUser($pdo, $username, $password);
    if($function == "loginSuccess") {
        header("Location: ../index.php");
    } elseif($function == "usernameDoesntExist") {
        $_SESSION['message'] = "Username does not exist!";
        header("Location: ../login.php");
    } elseif($function == "incorrectPassword") {
        $_SESSION['message'] = "Password is incorrect!";
        header("Location: ../login.php");
    }
}

if(isset($_POST['editUserButton'])) {
    $first_name = sanitizeInput($_POST['first_name']);
    $last_name = sanitizeInput($_POST['last_name']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $home_address = sanitizeInput($_POST['home_address']);
    $user_id = $_GET['user_id'];

    $function = updateUser($pdo, $first_name, $last_name, $age, $gender, $birthdate, $home_address, $user_id);
    if($function) {
        header("Location: ../index.php");
    } else {
        echo "<h2>User editing failed.</h2>";
        echo '<a href="../index.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to home page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    } 
}

if (isset($_POST['removeUserButton'])) {
	$function = removeUser($pdo, $_GET['user_id']);
	if($function) {
		header("Location: logout.php");
	} else {
		echo "<h2>User removal failed.</h2>";
		echo '<a href="../index.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to home page" style="padding: 6px 8px; margin: 8px 2px;">';
		echo '</a>';
	}
}

if (isset($_POST['addFranchiseButton'])) {
    $business_name = sanitizeInput($_POST['business_name']);
    $franchise_location = sanitizeInput($_POST['franchise_location']);

    $function = addFranchise($pdo, $_GET['user_id'], $business_name, $franchise_location);
    if($function) {
        header("Location: ../index.php?user_id=".$_GET['user_id']);
    } else {
        echo "<h2>Franchise addition failed.</h2>";
		echo '<a href="../viewPartnerFranchises.php?user_id=<?php .$_GET["user_id"] ?>">';
        echo '<input type="submit" id="returnPartnerFranchisesButton" value="Return to partner page" style="padding: 6px 8px; margin: 8px 2px;">';
		echo '</a>';
    }
}

if (isset($_POST['editFranchiseButton'])) {
    $business_name = sanitizeInput($_POST['business_name']);
    $franchise_location = sanitizeInput($_POST['franchise_location']);

    $function = editFranchise($pdo, $business_name, $franchise_location, $_GET['franchise_id']);
    if($function) {
        header("Location: ../index.php?user_id=".$_GET['user_id']);
    } else {
        echo "<h2>Franchise editing failed.</h2>";
		echo '<a href="../index.php?user_id=<?php .$_GET["user_id"] ?>">';
        echo '<input type="submit" id="returnPartnerFranchisesButton" value="Return to partner page" style="padding: 6px 8px; margin: 8px 2px;">';
		echo '</a>';
    }
}

if (isset($_POST['removeFranchiseButton'])) {
    $function = removeFranchise($pdo, $_GET['franchise_id']);
    if($function) {
        header("Location: ../index.php?user_id=".$_GET['user_id']);
    } else {
        echo "<h2>Franchise removal failed.</h2>";
		echo '<a href="../index.php?user_id=<?php .$_GET["user_id"] ?>">';
        echo '<input type="submit" id="returnPartnerFranchisesButton" value="Return to partner page" style="padding: 6px 8px; margin: 8px 2px;">';
		echo '</a>';
    }
}
?>