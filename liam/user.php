<?php
//includes
require_once(ABSPATH.'/data.php');

//see if the user is logged in
if(!(isset($_SESSION['userid']))){
?>
    <p class='error'>You do not have permission to view this page.</p>
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
    <form action="./admin/login.php" method="post">
        <label>Email:  </label><?php echo $user[0]["email"] ?><br />
        <label>Name:  </label><input type="text" name="name" value="<?php echo $user[0]["name"] ?>"><br />
        <label>Old Password: </label><input type="password" name="password"><br />
        <label>New Password: </label><input type="password" name="password"><br />
        <label>Retype Password: </label><input type="password" name="password"><br />
        <input type="submit" value="Update">
    </form>
    <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
    <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>

<?php
}
