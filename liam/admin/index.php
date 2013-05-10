<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<fieldset>
    <form action="login.php" method="post">
        <label>Username:  </label><input type="text" name="username"><br />
        <label>Password: </label><input type="password" name="password"><br />
        <input type="submit" value="login">
    </form>
    <span style="color:red;"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
</fieldset>
</body>
</html>