<?php

/**
 * Name:        Resource Management Profile Picture Updater
 * Programmer:  Liam Kelly
 * Date:        7/31/2013
 */

//Includes
require_once('path.php');
require_once(ABSPATH.'includes/data.php');

//fetch the user's info
$dbc = new db;
$dbc->connect();
$user = $dbc->query("SELECT * FROM people WHERE `index`='".$_SESSION['userid']."'");
$dbc->close();

?>
Your current profile picture:<br />
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
    <input type="submit" name="submit" value="Submit">
</form><br />

<a href="./?p=user">Go back</a>