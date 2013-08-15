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

    error_reporting(E_STRICT);

    //Make sure both fields are NOT empty
    if(!(empty($_REQUEST['username'])) && !(empty($_REQUEST['password']))){

        $users = new users;
        $results = $users->login($_REQUEST['username'], $_REQUEST['password']);

        if(!($results == FALSE)){

            //Make sure user is not locked indefinitely
            if($results[0]['lock_start'] > '0000-00-00' && $results[0]['lock_end'] == '0000-00-00'){

                //Check to see if the lock has started or not
                if(!($results[0]['lock_start'] > date('Y-m-d', time()))){

                    //Block user (lock has started)
                    header('location: ../?p=banned');

                    //For logging purposes
                    $banned = true;

                }


            }

            //Logging
            if($settings['logging'] == true){

                $ip = $_SESSION['REMOTE_ADDR'];

            }

            //Good login
            $_SESSION['userid'] = $results[0]['index'];
            $_SESSION['name'] = $results[0]['firstname'];
            $_SESSION['admin'] = $results[0]['admin'];
            $_SESSION['security_class'] = $results[0]['security_class'];
            $_SESSION['colorization'] = $results[0]['colorization'];
            header('location: ../');

            //In case of time out
            if(isset($_SESSION['timeout'])){
                unset($_SESSION['timeout']);
                unset($_SESSION['timestamp']);
            }


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
