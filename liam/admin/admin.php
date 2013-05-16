<?php
/**
 * Name:       Administrative Control Panel
 * Programmer: liam
 * Date:       5/10/13
 */

//start the session
session_start();

//includes
include_once('../data.php');

if(isset($_SESSION['userid']))
{

    //user has logged in

    $dbc = new db;
    $dbc->connect();
    $user = $dbc->query("SELECT * FROM people WHERE `index`='".$_SESSION['userid']."'");
    $dbc->close();

    switch($user[0]['admin'])
    {
        case true:
            echo "Hi, ".$user[0]['name']."! (<a href='./login.php?logout'>Logout</a>)";
            require_once('menu.php');
        break;

        case false:
            echo "You do not have permission to view this page!";
        break;


        default:
            echo "You do not have permission to view this page!";
        break;

    }


}
else
{

    //user is not logged in
    http_response_code(404);
    echo "You do not have permission to view this page!";

}