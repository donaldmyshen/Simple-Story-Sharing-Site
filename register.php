<?php
	require 'database.php';
	session_start();
	// get username password and email
	$username= $_SESSION['username'];
	// check the username 
	if ( !preg_match('/^[\w_\-]+$/', $username) ){
		echo "Invalid username";
		exit;
	}
	$pwd= $_SESSION['password'];
	$email= $_SESSION['email'];
	// hash password
	$pwd_hash= password_hash($pwd, PASSWORD_BCRYPT);
	// insert username pssword email to db
	$stmt= $mysqli->prepare("insert into users (username, password, email) values (?, ?, ?)");

	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('sss', $username, $pwd_hash, $email);
	 
	$stmt->execute();
	 
	$stmt->close();
	header("Location: login.php");
?>
