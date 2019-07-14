<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	  <title>Edit Post</title>
<link rel="stylesheet" href="profile.css">
</head>
<body>
    <h1><ins>Story </ins></h1>
    <form method="post">
        <label> Story Title: </label>
            <!--edit story titile-->
            <input type="text"  name="story_title"/><br>
        <label> About: </label>
            <!--edit story-->
            <input type="text"  id="story" name="story"/><br>
            <input type="submit" name="submit_story" value="Update"/><br>
            <input type="submit" name="cancel" value="Cancel"/><br>
    </form>

    <!--php-->
    <?php
        require 'database.php';
        session_start();
        
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }

        $post_id= $_SESSION['post_id'];

        if (isset($_POST['submit_story'])){
            $post_title= $_POST['story_title'];
            $post= $_POST['story'];
            // update title and content to db
            $stmt= $mysqli->prepare("update posts set post_title= ?, post= ? where post_id=?");
            if (!$stmt){
              printf("Query Prep Failed: %s\n", $mysqli->error);
              exit;
            }

            $stmt->bind_param('ssi', $post_title, $post, $post_id);

            $stmt->execute();

            $stmt->close();
            header("Location: post.php");
        }

        // not using it actually
        if (isset($_POST['cancel'])){
            header("Location: post.php");
        }

        if (isset($_POST['button'])){
            $post_id= $_SESSION['post_id'];

            //delete the comments related to post
            $stmt= $mysqli->prepare("delete from comments where post_id=?");

            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('i', $post_id);
            $stmt->execute();
            $stmt->close();

            //delete the post
            $stmt= $mysqli->prepare("delete from posts where post_id=?");

            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('i', $post_id);
            $stmt->execute();
            $stmt->close();
            header("Location: profile.php");
        }
    ?>
</body>
</html>

