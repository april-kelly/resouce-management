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

        if($_SESSION['timeout'] == true){
            echo '<span class="info">Session has timed out. Please login.</span>';
            $_SESSION['logout'] = false;
        }

        if(isset($_SESSION['banned'])){
            echo '<span class="error">Alert you have been banned!<br /><em>This event has been logged.</em></span>';
        }


?>