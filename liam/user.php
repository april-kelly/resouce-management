<?php
//see if the user is logged in
if(!(isset($_SESSION['userid']))){
?>
    <p class='error'>You do not have permission to view this page.</p>
<?php
}else{
?>

    <a href="./?p=logout">Log out</a>
    <form action="./admin/login.php" method="post">
        <label>Username:  </label><br />
        <label>Old Password: </label><input type="password" name="password"><br />
        <label>New Password: </label><input type="password" name="password"><br />
        <label>Retype Password: </label><input type="password" name="password"><br />
        <label>Email: </label><input type="text" name="email"><br />
        <input type="submit" value="login">
    </form>
    <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
    <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>
<?php
}
