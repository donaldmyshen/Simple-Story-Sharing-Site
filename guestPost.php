<?php
require "database.php";
session_start();
	if (isset($_POST['stories'])) {
		$_SESSION['post_id'] = $_POST['stories'];
	}
	$post_id = $_SESSION['post_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Post</title>
<link rel="stylesheet" href="profile.css">
</head>
<body>
<?php
	// guest will have no more func rather than view and register
	echo '<form action="guest.php" method="post">';
	echo '<input type="submit" value="Public Page "/>';
	echo '</form>';

	if (isset($_POST['button'])){
		$button= $_POST['button'];
		//Upvote
		if ($button== "Upvote Post"){
			$post_id = $_SESSION['post_id'];
			$stmt= $mysqli->prepare("update posts set upvote=upvote+1 where post_id=?");
				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}
				 
			$stmt->bind_param('i', $post_id);
			$stmt->execute();
			$stmt->close();
		}
	}

  	$stmt = $mysqli->prepare("select user_id, post_title, post, upvote, img_link from posts where post_id=?");

  	if (!$stmt){
  		printf("Query Prep Failed: %s\n", $mysqli->error);
  		exit;
  	}
  	 
	$stmt->bind_param('i', $post_id);
	$stmt->execute();
	$stmt->bind_result($poster_id, $post_title, $post, $upvote,$img_link);
	 
	while ($stmt->fetch()){
		echo "<h1><ins>".$post_title."<ins></h1>";

		if ($img_link){
			echo '<img src="'.$img_link.'" alt="image"><br>'; 
		}

		echo "<p>".$post."</p>";
		echo "<p1><b> Upvote :</b> ".$upvote."</p1>";
	}
	// guest will always have this boolean value equal to false
	$_SESSION['isPoster']= false;
 	$stmt->close();
?>
<hr>

<b><ins>Comments</ins></b>

<form>
<?php
	// guest still can read storys and commends 
	$stmt = $mysqli->prepare("select users.username, user_id, comment, comment_id from comments join users on (comments.user_id= users.id)where post_id=? ");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('i', $post_id);
	$stmt->execute();
	$stmt->bind_result($username,$commenter_id, $comment, $comment_id);

	while ($stmt-> fetch()){
		echo '<b>'.$username.':</b>';
		echo $comment; 
		echo '<br><br>';
	}

	$stmt->close();
?>
</form>

</body>
</html>

