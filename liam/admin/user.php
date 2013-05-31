<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link rel="stylesheet" href="../styles/styles.css" />

    <base href="http://localhost/resouce-management/liam/" target="_blank"/>

</head>
<body>

<div id="header">

    <img src="./images/logo.gif" />

    <?php

    require_once(dirname(__FILE__).'/nav.php');

    ?>

</div>
<div id="main" class="request">
    <a href="login.php?logout">Log out</a>
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
</div>
</body>
</html>