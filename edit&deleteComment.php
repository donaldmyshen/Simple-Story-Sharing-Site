<?php
    require 'database.php';
    session_start();  
    if(!hash_equals(trim($_SESSION['token']),trim($_POST['token']))){
        die("Request forgery detected");
    }
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Edit Comment</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>
    <h1>Comment </h1>
    <!--comment edit block-->
    <form method="post" action = "editComment.php">
        <label>Your Comment: </label>
        <input type="text"  id="comment" name="comment"/><br>
        <br>
        <input type="submit" name="update" value="Update"/><br>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
    <!--php-->
    <form method="post" action = "post.php">
        <input type="submit" name="cancel" value="Cancel"/><br>
    </form>
    <?php
        $comment_id= $_SESSION['comment_id'];
        // Edit and Delete comment from post.php
        if (isset($_POST['button'])){
            $_SESSION['comment_id']= (int)$_POST['comment_id'];
            $comment_id= $_SESSION['comment_id'];
            $button= $_POST['button'];
            // delete comment 
            if ($button== "Delete Comment"){
                $stmt= $mysqli->prepare("delete from comments where comment_id=?");

                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }

                $stmt->bind_param('i', $comment_id);
                $stmt->execute();
                $stmt->close();
                header("Location: post.php");
            }
        }
    ?> 
</body>
</html>