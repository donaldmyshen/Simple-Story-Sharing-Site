<?php
    require "database.php";
    session_start();
    // check the token
    if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
        echo  $_SESSION['token'];
        echo '<br>';     
        echo  $_POST['token'];
        echo '<br>';
        die("Request forgery detected");
    }
    // get user and comment
    $user_id= $_SESSION['user_id'];
    $comment= $_POST['comment'];
    $post_id= $_SESSION['post_id'];
    // insert in to db
    $stmt= $mysqli->prepare("insert into comments (user_id, post_id, comment) values (?, ?, ?)");

    if (!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('iis', $user_id, $post_id, $comment);
    $stmt->execute();
    $stmt->close();
    header('Location: post.php');
?>