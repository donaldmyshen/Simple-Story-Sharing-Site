<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My Profile</title>
<link rel="stylesheet" href="profile.css">
</head>
<body>
	<form id="btn" action="home.php" method="post">
			<input type="submit" name="logout_btn" value="Log Out"/>
	</form>
<h1>Profile</h1>
	<form action="publicPost.php" method="post">
			<input type="submit" name="main_page_btn" value="Public"/>
			<input type="hidden" name="token" value="
				<?php 
					echo $_SESSION['token'];
					?>" />

	</form>
<hr>
<p>My Posts </p>

<!--php-->
<form method="post" action='post.php'>
<?php
	ini_set("error_reporting","E_ALL & ~E_NOTICE");
	require 'database.php';
  	session_start();
	$user_id= $_SESSION['user_id'];
	$stmt= $mysqli->prepare("select post_id, post_title,hlink from posts where user_id=?");
	
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('i', $user_id); 
	$stmt->execute();
	$stmt->bind_result($post_id, $post_title,$hlink);
	// load all your own stories
	while($stmt-> fetch()){
			echo '<input type="radio" name="stories" value="'.$post_id.'"/>';
			if (!$hlink){
				printf("\t%s\n<br>", htmlspecialchars($post_title));
			} else{
				echo "<a href=http://".htmlspecialchars($hlink).">" .$post_title. "</a><br>";
			}
		}
	$stmt->close();
?>
	<br>
  	<input type="submit" name="button" value="View"/>
  	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
</form>
<br>
<br>
<form action="writePostTemp.php" method="post">
	<input type="submit" value="Wirte a Story"/>
</form>
</body>
</html>
