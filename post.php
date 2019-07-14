<?php
	ini_set("error_reporting","E_ALL & ~E_NOTICE");
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
	if(isset($_SESSION['user_id'])){
		echo '<form action="profile.php" method="post">';
		echo '<input type="submit" value="My Profile "/>';
		echo '</form>';
	}

	echo '<form action="publicPost.php" method="post">';
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

	// fileds need to be shown 
  	$stmt = $mysqli->prepare("select user_id, post_title, post, upvote, img_link from posts where post_id=?");

  	if (!$stmt){
  		printf("Query Prep Failed: %s\n", $mysqli->error);
  		exit;
  	}
  	 
	$stmt->bind_param('i', $post_id);
	$stmt->execute();
	$stmt->bind_result($poster_id, $post_title, $post, $upvote,$img_link);
	 
	while ($stmt->fetch()){
		echo "<h1><ins>".$post_title."</ins></h1>";

		if ($img_link){
			echo '<img src="'.$img_link.'" alt="image"><br>'; 
		}

		echo "<p>".$post."</p>";
		echo "<p1><b> Upvote :</b> ".$upvote."</p1>";
	}
	// check if user is poster
	if ($poster_id== $_SESSION['user_id']){
		$_SESSION['isPoster']= true;
	}
	else {
		$_SESSION['isPoster']= false;
	}

 	$stmt->close();
?>
<hr>
<form method="post">
	<input type="submit" name="button" value="Upvote Post"/><br><br>
</form>

<form  method="post" action="editPostTemp.php">
	<?php
		if ($_SESSION['isPoster']){
			echo '<input type="submit" name="button" value="Edit Post"/>';	
		}
	?>
	</form>

	<form  method="post" action="deletePost.php">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
	<?php
		if ($_SESSION['isPoster']){
			echo '<input type="submit" name="button" value="Delete Post"/>';
		}
	?>
</form>

<b><ins>Comments</ins></b>

<form  action="edit&deleteComment.php" method="post">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<?php

	$stmt = $mysqli->prepare("select users.username, user_id, comment, comment_id from comments join users on (comments.user_id= users.id)where post_id=? ");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('i', $post_id);
	$stmt->execute();
	$stmt->bind_result($username,$commenter_id, $comment, $comment_id);
	$_SESSION['comment_id']=$comment_id;
	while ($stmt-> fetch()){
		// allow user edit and delete his own comment
		if (isset($_SESSION['user_id'])){
			if ($commenter_id== $_SESSION['user_id']){
				echo '<input type="radio" name="comment_id" value="';
				echo $comment_id;
				echo '"/>';
				echo '<b>'.$username.':</b> ';
				printf("\t%s\n<br>",
					htmlspecialchars($comment)
				);
			}
			else {
				echo '<b>'.$username.':</b>';
				echo $comment; 
				echo '<br><br>';
			}
		}
	}

	$stmt->close();
	// guest can't comment
	if (isset($_SESSION['user_id'])){
		echo '<br>';
		echo '<input type="submit" name="button" value="Edit Comment"/>';
		echo '<input type="submit" name="button" value="Delete Comment"/>';
	}
?>
</form>
<br>
<br>
<form  method="post" action="addCom.php">
	<input type="hidden" name="token" value=" <?php echo $_SESSION['token'];?>" />
<?php
	if (isset($_SESSION['user_id'])){
		echo '<label> Your Comment:</label>';
		echo '<input type="text" name="comment"/>';
		echo '<input type="submit" name="button" value="Comment"/>';
	}
?>
</form>
</body>
</html>

