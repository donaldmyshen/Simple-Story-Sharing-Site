<?php
	require 'database.php';

	session_start();
	 
	require 'database.php';
	$username= $_SESSION['username'];
	// check username
	if ( !preg_match('/^[\w_\-]+$/', $username) ){
		echo "Invalid username";
		exit;
	}
	$pwd_guess= $_SESSION['password'];
	 
	// Use a prepared statement
	$stmt = $mysqli->prepare("SELECT COUNT(*), id, password FROM users WHERE username=?");
	 
	// Bind the parameter
	$stmt->bind_param('s', $username);
	$stmt->execute();
	 
	// Bind the results
	$stmt->bind_result($cnt, $user_id, $pwd_hash);
	$stmt->fetch();
	$bool = password_verify($pwd_guess,  $pwd_hash);

	// Compare the submitted password to the actual password hash
	if($cnt == 1 && $bool){
		// Login succeeded, go to profile page
		$_SESSION['user_id'] = $user_id;
		$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
		header("Location: profile.php");
	}else{
		// Login failed, redirect back to the login screen
		echo "Invalid password!";
		//header("Location: home.php");
	}
?>
