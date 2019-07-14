<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ShareYourStory</title>
<link rel="stylesheet" href="profile.css">
</head>

<body>
<?php

/*logout*/
  if (isset($_POST['logout_btn'])){
    $_SESSION= array();
    session_destroy();
    echo "logout!";
  }
	
/*register*/
	if (isset ($_POST ['register'])){
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
		$_SESSION['email']= $_POST['email'];
		header("Location: register.php");
	}
/*login*/
	if (isset ($_POST ['login'])){
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
		header("Location: login.php");
	}
?>

<h1> Welcome share your story!</h1>

<!--Rigester form-->
<form method= "post">
	<label>Username: </label>
		<input type= "text" name= "username"/><br>
	<label>Password: </label>
		<input type= "password" name= "password"/><br>
	<label>Email: </label> 
		<input type= "email" name= "email"/><br>
	<input type= "submit" name="register" value= "Register"/>
</form>

<br>

<!--LogIn form-->
<form method= "post">
	<label>Username: </label>
		<input type= "text" name= "username"/><br>
	<label>Password: </label>
		<input type= "password" name= "password"/><br>
	<input type= "submit" name="login" value="log in"/>
</form>

<form method= "post" action="guest.php">
	<input type= "submit" name="Guest" value="Guest"/>
</form>

</body>
</html>
