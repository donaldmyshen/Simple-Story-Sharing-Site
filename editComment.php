<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
require 'database.php';
session_start();  
if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
    die("Request forgery detected");
}
if (isset($_POST['update'])){
    // get comment
    $comment_id= $_SESSION['comment_id'];
    $comment= $_POST['comment'];
    // update comment to db
    $stmt= $mysqli->prepare("update comments set comment=?  where comment_id=?");

    if (!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('si',$comment, $comment_id );
    $stmt->execute();
    $stmt->close();
    header("Location: post.php");
}
?>