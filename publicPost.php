<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Public Post</title>
<link rel="stylesheet" href="profile.css">
</head>
<body>
    <h1>StorySharing</h1>
<?php
    ini_set("error_reporting","E_ALL & ~E_NOTICE");
    require 'database.php';
    session_start();
    // if login, form to my profile and logout
	if (isset($_SESSION['user_id'])){
	    echo'<form action="profile.php">';
	    echo'<input type="submit" value="My Profile"/>';
	    echo'</form>';
	    echo'<form id="btn1" action="home.php" method="post">';
	    echo'<input type="submit" name="logout_btn" value="Log Out"/>';
	    echo'</form>';
    }
    // else, form to login
    else {
	    echo'<form id="btn2" action="home.php">';
	    echo'<input type="submit" value="Login"/>';
	    echo'</form>';
    }
?>

<form method="post" action = "post.php">
<?php
    $stmt= $mysqli->prepare("select users.username, post_id, post_title, hlink from posts join users on (posts.user_id=users.id) ");

    if (!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();
    $stmt->bind_result($username, $post_id, $post_title,$hlink);
    // load all stories 
    while ($stmt-> fetch()){
        echo '<input type="radio" name="stories" value="'.$post_id.'"/>';
        printf ("\t%s\n<br>", htmlspecialchars($post_title));
		echo '<p>posted by '.$username.'<br>';
        if($hlink){
            echo "<a href=http://".htmlspecialchars($hlink).">" ."Reference Link". "</a>";
        }
        echo '</p><hr>';
    }
    $stmt->close();
?>
  <br>
  <input type="submit" name="button" value="View"/>
  <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
</form>

</body>
</html>
