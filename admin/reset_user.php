<?php
/**
 * Name:       User password reset script
 * Programmer: Liam Kelly
 * Date:       7/15/13
 */

//Redirect the user if they have input a code
if(isset($_REQUEST['c'])){
    if(!(isset($_SESSION['reset_code']))){
        header('location: ./?p=reset&c='.$_REQUEST['c'].'');
    }
}

//Make sure the ABSPATH constant is defined
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}

//includes
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/users.php');

if(!(isset($_SESSION))){
    session_start();
}



if(isset($_SESSION['reset_code'])){

    //The user has already provided a reset code


    //Lookup the reset code
    $users = new users;
    $results = $users->reset_code($_SESSION['reset_code']);

    if(!($results == false)){

        //Good reset code

        //show the password reset form
        ?>

        <form action="./admin/save.php" method="post">
            <b>Password Reset: </b><br />
            <input type="hidden" value="<?php echo $_SESSION['reset_code']; ?>" name="reset_code" />
            <label>New Password: </label><input type="password" name="new_pass"><br />
            <label>Retype Password: </label><input type="password" name="new_pass_II"><br />
            <input type="submit" value="Reset">
        </form>

        <?php

    }else{

        //Bad reset code
        echo '<span class="error">The reset code you provided is no longer valid.</span>';

    }

    //Unset the reset code when we are finished
    unset($_SESSION['reset_code']);

}else{

    //The user has not provided the code yet

    //echo out the input form
    ?>

    <form action="./" method="get">
        <b>Please input your reset code.</b>
        <input type="hidden" name="p" value="reset_code" />
        <input type="text" name="c" />
        <input type="submit">
    </form>


    <?php
}

