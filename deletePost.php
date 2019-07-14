<?php
    require "database.php";
    session_start();
    if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
        die("Request forgery detected");
    }
    $post_id= $_SESSION['post_id'];
    //delete the comments related to post
    $stmt= $mysqli->prepare("delete from comments where post_id=?");

    if (!$stmt){
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
?>