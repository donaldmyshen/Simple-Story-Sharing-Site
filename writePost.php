<!--php-->
<?php
    require 'database.php';
    session_start();
    if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
        die("Request forgery detected");
    }
    $user_id= $_SESSION['user_id'];

    if (isset($_POST['submit_story'])){
        // get title, stroy
        $post_title= $_POST['story_title'];
		$post= $_POST['story'];
        // set defalt tpvote time to 0
		$upvote= 0;
        // link and image can ge empty
		$_SESSION['hlink']= $_POST['story_link'];
		$hlink= $_SESSION['hlink'];
		$img_link= $_POST['img_link'];
        // insert in to db
        $stmt= $mysqli->prepare("insert into posts (user_id, post_title, post, upvote, hlink, img_link) values (?, ?, ?, ?, ?, ?)");
        
        if (!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('ississ', $user_id, $post_title, $post,$upvote, $hlink, $img_link);
        $stmt->execute();
        $stmt->close();
        header("Location: profile.php");
    }

    if (isset($_POST['cancel'])){
        header("Location: profile.php");
	}
?>
