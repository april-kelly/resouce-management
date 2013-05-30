<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link rel="stylesheet" href="../styles/styles.css" />

    <base href="http://localhost/resouce-managment/liam/" target="_blank"/>

</head>
<body>

<?php

    require_once('../header.php');

?>
    <div id="login">
        <form action="login.php" method="post">
           <label>Username:  </label><input type="text" name="username"><br />
           <label>Password: </label><input type="password" name="password"><br />
           <input type="submit" value="login">
        </form>
        <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
        <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>
    </div>
</body>
</html>