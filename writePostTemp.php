<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Write A Post</title>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="profile.css">
</head>

<?php
    session_start();
?>

<body>
    <h1><ins>Story</ins> </h1>
    <form method="post" action="writePost.php">
        <label> Story Title: </label>
            <input type="text"  name="story_title"/><br>
        <label> Link: </label>
            <input type="text"  name="story_link"/><br>
        <label>Image Link: </label>
            <input type="text"  name="img_link"/><br>
        <label> About: </label>
            <input type="text"  id="story" name="story"/><br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>"/>
            <input type="submit" name="submit_story" value="Submit"/><br>
            <input type="submit" name="cancel" value="Cancel"/><br>	
    </form>
</body>
</html>
