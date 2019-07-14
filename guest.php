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
    require 'database.php';
    session_start();
	echo'<form id="btn" action="home.php" method="post">';
    echo'<input type="submit" name="logout_btn" value="Register"/>';
	echo'</form>';
?>

<form method="post" action = "guestPost.php">
<?php
    $stmt= $mysqli->prepare("select users.username, post_id, post_title, hlink from posts join users on (posts.user_id=users.id) ");

    if (!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->execute();
    $stmt->bind_result($username, $post_id, $post_title,$hlink);
    // load storys 
    while ($stmt-> fetch()){
        echo '<input type="radio" name="stories" value="'.$post_id.'"/>';
        printf ("\t%s\n<br>", htmlspecialchars($post_title));
        echo '<p>posted by '.$username.'<br>';
        // if have a reference link load it
        if($hlink){
            echo "<a href=http://".htmlspecialchars($hlink).">" ."Reference Link". "</a>";
        }
        echo '</p><hr>';
    }
    $stmt->close();
?>
  <br>
  <input type="submit" name="button" value="View"/>
</form>

</body>
</html>
