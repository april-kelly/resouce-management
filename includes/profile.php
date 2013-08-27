<?php

//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}

//includes
require_once('path.php');
require_once(ABSPATH.'/includes/data.php');

//Get rid of user_lookup so that update_pic.php show the correct user
unset($_SESSION['user_lookup']);

//see if the user is logged in
if(!(isset($_SESSION['userid']))){
?>
    <p class='error'>Congratulations you have just proven <a href="http://en.wikipedia.org/wiki/Schr%C3%B6dinger's_cat">Schr&#246;dinger's</a> thought experiment correct!
        You do not exist but yet you are accessing this page! Therefore you exist and do not exist
        at the same time. (This probably just means you have not logged).</p>
<?php
}else{

    //fetch the user's info
    $dbc = new db;
    $dbc->connect();
    $user = $dbc->query("SELECT * FROM people WHERE `index`='".$_SESSION['userid']."'");
    $dbc->close();


    ?>

    <form action="./" method="get" class="button">
        <input type="hidden" name="p" id="p" value="logout" />
        <input type="submit" value="Logout" />
    </form>

    <h3>Your profile:</h3>
    <form action="./admin/save.php" method="post" class="button">
        Profile Picture <br /><a href="./?p=edit_pic">
        <img src="<?php
        if(!(empty($user[0]["profile_pic"]))){
            echo './includes/images/uploads/'.$user[0]["profile_pic"];
        }else{
            echo './includes/images/default.jpg';
        }
        ?>" alt="Click to edit" title="Click to edit" class="profile_pic"/></a><br /><br />
        <input type="hidden" value="<?php echo $user[0]["index"]; ?>" name="userid" />
        <input type="hidden" value="<?php echo $user[0]["email"]; ?>" name="email" />
        <label>Colorize Results</label>
        <input type="hidden" name="month_colors" value="0" />
        <input type="checkbox" name="month_colors" value="1" <?php if($user[0]["colorization"] == TRUE){ echo "checked"; } ?> /><br /><br />
        <label>Email:  </label><?php echo $user[0]["email"] ?><br /><br />
        <label>Phone Number: </label><input type="text" name="phone_number" value="<?php echo $user[0]["phone_number"] ?>" autocomplete="off"/><br /><br />
        <label>First:  </label><input type="text" name="firstname" value="<?php echo $user[0]["firstname"] ?>"><br /><br />
        <label>Last:  </label><input type="text" name="lastname" value="<?php echo $user[0]["lastname"] ?>"><br /><br />
        <label>Current Password: </label><input type="password" name="password"><br /><br />
        <label>New Password: </label><input type="password" name="new_pass"><br /><br />
        <label>Retype Password: </label><input type="password" name="new_pass_II"><br /><br />
        <input type="submit" value="Update">
        <br /><span class="info"><i>Please enter your current password, even if you are not changing your password.</i></span>
    </form>
    <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
    <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>

<?php
}
