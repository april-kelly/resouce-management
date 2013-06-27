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

//ensure the user filled out both inputs
if(isset($_REQUEST['username']) && isset($_REQUEST['password']))
{

    //connect to the database
    $dbc = new db;
    $dbc->connect();

    //sanitize user inputs
    $user = $dbc->sanitize($_REQUEST['username']);
    $pass =$dbc->sanitize(sha1($_REQUEST['password']));

    //search for user
    $results = $dbc->query("SELECT * FROM people WHERE email='".$user."' AND password='".$pass."'");

    //close connection
    $dbc->close();


    if(count($results) == '1')
    {

       //valid login
       $_SESSION['userid'] = $results[0]['index'];
       $_SESSION['name'] = $results[0]['name'];
       header('location: ../?p=admin');

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
