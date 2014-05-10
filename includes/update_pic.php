<?php

/**
 * Name:        Resource Management Profile Picture Updater
 * Programmer:  Liam Kelly
 * Date:        7/31/2013
 */

//Includes
require_once('path.php');
require_once(ABSPATH.'includes/data.php');

//Define the user to deal with
if(isset($_SESSION['user_lookup'])){
    $userid = $_SESSION['user_lookup'];
}else{
    $userid = $_SESSION['userid'];
}

//fetch the user's info
$dbc = new db;
$dbc->connect();
$user = $dbc->query("SELECT `firstname` FROM people WHERE `index`='".$userid."'");
$dbc->close();

if(!($_SESSION['userid'] == $userid)){
    echo '<h3>'.$user[0]['firstname']."'s";
}else{
    echo '<h3>My ';
}

?>
 profile picture:</h3><br />
        <img src="<?php
        if(!(empty($user[0]["profile_pic"]))){
            echo './includes/images/uploads/'.$user[0]["profile_pic"];
        }else{
            echo './includes/images/default.jpg';
        }
        ?>" alt="User Profile Image" title="User Profile Image" class="profile_pic"/><br />


<br /><b>Change: </b><br />
<form action="./includes/images/uploads/upload.php" method="post"
      enctype="multipart/form-data">
    <input type="file" name="file" id="file"><br>
    <input type="submit" name="submit" value="Upload">
    <?php
    if(isset($_SESSION['wrong_type'])){
    echo '<span class="error">Wrong file type, size, or name, you may upload .jpg, .bmp, .gif, and .png files.</span>';
    }
    ?>
</form>
<form action="./includes/images/uploads/upload.php" method="post">
    <br /><b>Delete:</b><br />
    <input type="submit" name="delete" value="Delete">
</form><br />

<?php
if(isset($_SESSION['user_lookup'])){
    echo '<a href="./?p=admin">Go back</a>';
}else{
    echo '<a href="./?p=user">Go back</a>';
}



?>
