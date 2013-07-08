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

//ensure the user filled out both inputs
if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
{

    $users = new users;
    $results = $users->login($_REQUEST['username'], $_REQUEST['password']);

    if(!($results == FALSE)){

        //Good login
        $_SESSION['userid'] = $results[0]['index'];
        $_SESSION['name'] = $results[0]['name'];
        $_SESSION['admin'] = $results[0]['admin'];
        header('location: ../');

    }else{

        //Bad login
        header('location: ../?p=badlogin');

    }

}
else
{

    //user did not fill out both fields
    header('location: ../?p=badlogin');

}
