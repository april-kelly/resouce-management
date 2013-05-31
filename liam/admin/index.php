        <form action="./admin/login.php" method="post">
           <label>Username:  </label><input type="text" name="username"><br />
           <label>Password: </label><input type="password" name="password"><br />
           <input type="submit" value="login">
        </form>
        <span class="error"><?php if(isset($_REQUEST['bad'])){ echo 'Incorrect username or password.'; } ?></span>
        <span class="info"><?php if(isset($_REQUEST['logout'])){ echo 'Logged out.'; } ?></span>