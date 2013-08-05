<?php
/*
 * Name: Admin Login
 * Programmer: Liam Kelly
 * Date: 5/9/13
 */

//start the session
session_start();

//includes
require_once('../path.php'); //to set the ABSPATH constant
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//fetch the salt
$set = new settings;
$settings = $set->fetch();
$salt = $settings['salt'];

//Make sure both fields exist
if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
{

    //Make sure both fields are NOT empty
    if(!(empty($_REQUEST['username'])) && !(empty($_REQUEST['password']))){

        $users = new users;
        $results = $users->login($_REQUEST['username'], $_REQUEST['password']);

        if(!($results == FALSE)){

            //Good login
            $_SESSION['userid'] = $results[0]['index'];
            $_SESSION['name'] = $results[0]['firstname'];
            $_SESSION['admin'] = $results[0]['admin'];
            $_SESSION['security_class'] = $results[0]['security_class'];
            $_SESSION['colorization'] = $results[0]['colorization'];
            header('location: ../');

        }else{

            //Bad login
            header('location: ../?p=badlogin');

        }

    }else{

        //One or more fields is empty
        header('location: ../?p=badlogin');

    }

}
else
{

    //Both fields do not exist
    header('location: ../?p=badlogin');

}
