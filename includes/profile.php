<?php

//includes
require_once('path.php');
require_once(ABSPATH.'/includes/data.php');

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

    <a href="./?p=logout">Log out</a>
    <h3>Your profile:</h3>
    <form action="./admin/save.php" method="post">
        <input type="hidden" value="<?php echo $user[0]["index"]; ?>" name="userid" />
        <input type="hidden" value="<?php echo $user[0]["email"]; ?>" name="email" />
        <label>Email:  </label><?php echo $user[0]["email"] ?><br />
        <label>Name:  </label><input type="text" name="name" value="<?php echo $user[0]["name"] ?>"><br />
        <label>Current Password: </label><input type="password" name="password"><br />
        <label>New Password: </label><input type="password" name="new_pass"><br />
        <label>Retype Password: </label><input type="password" name="new_pass_II"><br />
        <input type="submit" value="Update">
        <br /><span class="info"><i>Please enter your current password, even if you are not changing your password.</i></span>
    </form>
    <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
    <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>

<?php
}