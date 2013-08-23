<?php
 if(!(isset($_SESSION['ref']))){
?>
        <h2>Sign in</h2>
        <form action="./admin/login.php" method="post" class="button">
           <strong><label>Username:  </label></strong><input type="text" name="username"><br /><br />
           <strong><label>Password: </label></strong><input type="password" name="password"><br />
           <!--<input type="submit" value="login">--><br />
           <input type="submit" name="submit" value="Login">
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

}else{

    //The user needs to enter an Authentication code
    if(!(isset($_SESSION['auth_code']))){
        header('location: ./admin/login.php?auth_code=');
    }
    ?>
    <h2>Verify</h2><br/>
    <form action="./admin/login.php" method="post" class="button">
           <!--<label>Code: </label>--><input type="text" name="auth_code"><br /><br />
            <input type="submit" name="submit" value="Verify">
    </form>


<?php

    if($_SESSION['badcode'] == true){
        echo '<span class="error">Invalid authentication code.<br /><em>This event has been logged.</em></span>';
    }else{
        echo '<br /><span class="info">Please enter the verification code we sent to your phone.</span><br />';
    }

}
?>