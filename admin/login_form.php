        <form action="./admin/login.php" method="post">
           <label>Username:  </label><input type="text" name="username"><br />
           <label>Password: </label><input type="password" name="password"><br />
           <input type="submit" value="login">
        </form>
        <span class="error"><?php if(isset($_SESSION['bad'])){ echo 'Incorrect username or password.'; unset($_SESSION['bad']);} ?></span>
<?php

        if(isset($_SESSION['logout']) && $_SESSION['logout'] == true){
            echo '<span class="info">Logged out.</span>';
            $_SESSION['logout'] = false;
        }

?>