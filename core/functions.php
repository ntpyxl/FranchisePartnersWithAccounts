<?php
require_once 'dbConfig.php';

function getAllPartners($pdo) {
    $query = "SELECT * FROM users";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute();
	
    if ($executeQuery) {
		return $statement -> fetchAll();
	}
}

function getAllPartnersExceptID($pdo, $user_id) {
    $query = "SELECT * FROM users WHERE NOT user_id = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$user_id]);
	
    if ($executeQuery) {
		return $statement -> fetchAll();
	}
}

function getUserByID($pdo, $user_id) {
	$query = "SELECT * FROM users WHERE user_id = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$user_id]);
	
    if ($executeQuery) {
		return $statement -> fetch();
	}
}

function checkUsernameExistence($pdo, $username) {
	$query = "SELECT * FROM user_accounts WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function checkUserExistence($pdo, $first_name, $last_name, $age, $gender, $birthdate) {
	$query = "SELECT * FROM users 
				WHERE first_name = ? AND 
				last_name = ? AND
				age = ? AND
				gender = ? AND
				birthdate = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$first_name, $last_name, $age, $gender, $birthdate]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function addUser($pdo, $username, $password, $first_name, $last_name, $age, $gender, $birthdate, $home_address) {
	if(checkUsernameExistence($pdo, $username)) {
		return "UsernameAlreadyExists";
	}
	if(checkUserExistence($pdo, $first_name, $last_name, $age, $gender, $birthdate)) {
		return "UserAlreadyExists";
	}

	$query1 = "INSERT INTO user_accounts (username, user_password) VALUES (?, ?)";
	$statement1 = $pdo -> prepare($query1);
	$executeQuery1 = $statement1 -> execute([$username, $password]);

    $query2 = "INSERT INTO users (first_name, last_name, age, gender, birthdate, home_address) VALUES (?, ?, ?, ?, ?, ?)";
    $statement2 = $pdo -> prepare($query2);
	$executeQuery2 = $statement2 -> execute([$first_name, $last_name, $age, $gender, $birthdate , $home_address]);
    
    if ($executeQuery1 && $executeQuery2) {
		return "registrationSuccess";	
	}
}

function loginUser($pdo, $username, $password) {
	if(!checkUsernameExistence($pdo, $username)) {
		return "usernameDoesntExist";
	}

	$query = "SELECT * FROM user_accounts WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$statement -> execute([$username]);
	$userAccInfo = $statement -> fetch();

	if(password_verify($password, $userAccInfo['user_password'])) {
		$_SESSION['user_id'] = $userAccInfo['user_id'];
		$_SESSION['username'] = $userAccInfo['username'];
		return "loginSuccess";
	} else {
		return "incorrectPassword";
	}
}

function updateUser($pdo, $first_name, $last_name, $age, $gender, $birthdate, $home_address, $user_id) {
	$query = "UPDATE users
				SET first_name = ?,
                last_name = ?,
                age = ?,
                gender = ?,
                birthdate = ?,
                home_address = ?
			WHERE user_id = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$first_name, $last_name, $age, $gender, $birthdate, $home_address, $user_id]);
	
    if ($executeQuery) {
		return true;
	}
}

function removeUser($pdo, $user_id) {
	$query1 = "DELETE FROM franchises WHERE owner_id = ?";
	$statement1 = $pdo -> prepare($query1);
	$executeQuery1 = $statement1 -> execute([$partner_id]);

	if($executeQuery1) {
		$query2 = "DELETE FROM users WHERE user_id = ?";
		$statement2 = $pdo -> prepare($query2);
		$executeQuery2 = $statement2 -> execute([$user_id]);
		
		if ($executeQuery2) {
			return true;
		}
	}
}

function getFranchiseByID($pdo, $franchise_id) {
	$query = "SELECT
				franchise_id,
				owner_id,
				business_name,
				franchise_location,
				date_franchised
			FROM franchises
			WHERE franchise_id = ?
			GROUP BY franchise_id;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute([$franchise_id]);
		
		if ($executeQuery) {
			return $statement -> fetch();
		}
}

function getFranchisesByPartnerID($pdo, $user_id) {
	$query = "SELECT
				franchises.franchise_id,
				franchises.business_name,
				franchises.franchise_location,
				franchises.date_franchised
			FROM franchises
			JOIN users ON franchises.owner_id = users.user_id
			WHERE users.user_id = ?;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute([$user_id]);
		
		if ($executeQuery) {
			return $statement -> fetchAll();
		}
}

function getNewestFranchiseID($pdo) {
	$query = "SELECT franchise_id
			FROM franchises
			ORDER BY franchise_id DESC
    		LIMIT 1;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute();
		
		if ($executeQuery) {
			return $statement -> fetch();
		}
}

function addFranchise($pdo, $user_id, $business_name, $franchise_location) {
	$query = "INSERT INTO franchises (owner_id, business_name, franchise_location) VALUES (?, ?, ?)";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$user_id, $business_name, $franchise_location]);
    
    if ($executeQuery) {
		$franchiseID = getNewestFranchiseID($pdo)['franchise_id'];
		$franchiseData = getFranchiseByID($pdo, $franchiseID);
		logFranchiseAction($pdo, "ADDED", $franchiseID, $franchiseData['owner_id'], $_SESSION['user_id']);
		return true;	
	}
}

function editFranchise($pdo, $business_name, $franchise_location, $franchise_id) {
	$franchiseData = getFranchiseByID($pdo, $franchise_id);

	$query = "UPDATE franchises
				SET business_name = ?,
					franchise_location = ?
				WHERE franchise_id = ?";
    $statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$business_name, $franchise_location, $franchise_id]);
    
    if ($executeQuery) {
		logFranchiseAction($pdo, "EDITED", $franchise_id, $franchiseData['owner_id'], $_SESSION['user_id']);
		return true;	
	}
}

function removeFranchise($pdo, $franchise_id) {
	$franchiseData = getFranchiseByID($pdo, $franchise_id);

	$query = "DELETE FROM franchises WHERE franchise_id = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$franchise_id]);

	if ($executeQuery) {
		logFranchiseAction($pdo, "REMOVED", $franchise_id, $franchiseData['owner_id'], $_SESSION['user_id']);
		return true;	
	}
}

function logFranchiseAction($pdo, $log_desc, $franchise_id, $owner_id, $done_by) {
	$query = "INSERT INTO franchise_logs (log_desc, franchise_id, owner_id, done_by) VALUES (?, ?, ?, ?)";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$log_desc, $franchise_id, $owner_id, $done_by]);

	if ($executeQuery) {
		return true;	
	}
}

function getFranchiseLogs($pdo) {
	$query = "SELECT * FROM franchise_logs ORDER BY date_logged DESC";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute();
	
    if ($executeQuery) {
		return $statement -> fetchAll();
	}
}
?>