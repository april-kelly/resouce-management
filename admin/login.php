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

//fetch the salt
$set = new settings;
$settings = $set->fetch();
$salt = $settings['salt'];

//ensure the user filled out both inputs
if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
{

    //connect to the database
    $dbc = new db;
    $dbc->connect();

    //sanitize user inputs
    $user = $dbc->sanitize($_REQUEST['username']);
    $pass = $dbc->sanitize(hash('SHA512', $_REQUEST['password'].$salt));

    //search for user
    $results = $dbc->query("SELECT * FROM people WHERE email='".$user."' AND password='".$pass."'");

    //close connection
    $dbc->close();


    if(count($results) == '1')
    {

       //valid login
       $_SESSION['userid'] = $results[0]['index'];
       $_SESSION['name'] = $results[0]['name'];
       $_SESSION['admin'] = $results[0]['admin'];
       header('location: ../');

    }
    else
    {

        //invalid login
        header('location: ../?p=badlogin');

    }

}
else
{

    //use did not fill out both fields
    header('location: ../?p=badlogin');

}
