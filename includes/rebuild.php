<?php
/**
 * Name:       Resource Management Rebuild Tool
 * Programmer: Liam Kelly
 * Date:       8/29/13
 */

//Setup session
if(!(isset($_SESSION))){
    session_start();
}

//Includes
include_once('../path.php');
include_once(ABSPATH.'includes/data.php');
include_once(ABSPATH.'includes/config/settings.php');

//Prepare to rebuild

    //Recreate the salt

    //Check for the platform
    if(php_uname('s') == 'Linux'){

        //Okay, were running on linux so, use /dev/urandom
        //This is more secure (f.y.i)

        //Get some random
        $fp = fopen('/dev/urandom', 'r');

        //Hash the randomness
        $salt = hash('SHA512', fread($fp, 512));

    }else{

        //Were not on linux so, well use the less secure mt_rand() function
        $salt = hash('SHA512', mt_rand());

    }

    $replacements = array(
        1 => $_SESSION['step1']['db_host'],
        2 => $_SESSION['step1']['db_user'],
        3 => $_SESSION['step1']['db_pass'],
        4 => $_SESSION['step1']['db_database'],
        5 => $_SESSION['step1']['server_domain'],
        6 => $salt,
        7 => '',
        8 => $_SESSION['step1']['server_dir'],
        9 => php_uname('s'),
    );

    //Setup the settings class
    $set = new settings;
    //$set->rebuild($replacements);
echo 'hello';
