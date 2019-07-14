<?php
    $comment_id= $_SESSION['comment_id'];
    require 'database.php';
    session_start();

    if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
        die("Request forgery detected");
    }

    $post_id= $_SESSION['post_id'];

    if (isset($_POST['submit_story'])){
        // get tiltle and story
        $post_title= $_POST['story_title'];
        $post= $_POST['story'];
        // update to db
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
    
    if (isset($_POST['cancel'])){
        header("Location: post.php");
    }
?>