<?php
/**
 * Name:       Resource Management Installer -- Step 3 of 3
 * Programmer: Liam Kelly
 * Date:       7/16/13
 */

//start the users session
if(!(isset($_SESSION))){
session_start();
}

//includes
require_once('../../path.php');
require_once('../config/settings.php');
require_once('./create_db.php');
require_once('../config/users.php');

//Fetch data from step 2
$_SESSION['step2'] = $_REQUEST;

?>

<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="../styles/styles.css" type="text/css" />
    <link rel="icon" href="../images/btm_favicon.ico" />


</head>
<body>

<div id="installer">

    <h1>Step 3: Installation</h1><hr />

    <p>
        Please wait while we install, this should just take a moment....
    </p>

    <?php

        //Ensure the system is not already installed
        if(!(file_exists('../config/settings.json'))){

            //Create the settings file
            create_settings(
                $_SESSION['step1']['db_user'],
                $_SESSION['step1']['db_host'],
                $_SESSION['step1']['db_pass']
            );
            echo '<span class="success">Created settings file.</span><br />';

            //...and for the database
            create_db($_SESSION['step1']['db_database']);
            echo '<span class="success">Created database.</span><br />';

            //...Finally the user
            $users = new users;

            $users->change('index', null);
            $users->change('name',      $_SESSION['step2']['first_name']);
            $users->change('email',     $_SESSION['step2']['email']);
            $users->change('password',  $_SESSION['step2']['password']);
            $users->change('type',      '2');
            $users->change('admin',     '1');

            $users->create();
            echo '<span class="success">Added user: '.$_SESSION['step2']['first_name'].'.</span><br />';

        }else{
            ?><span class="error">It appears that you have already installed. Did you mean to preform a <a href="../config/reset.php">repair</a> instead?</span><?php
        }
    ?>
    <p>
        <a href="../../">Continue</a>
    </p>

</div>

</body>
</html>
