<?php
/**
 * Name: Salt Generator
 * Programmer: Liam Kelly
 * Date: 7/8/13
 * Note: This file should be removed before production
 * Note: Most functionality in this file has been added to save.php
 */

//includes
if(!(defined('ABSPATH')){
    include_once('../../path.php');
}
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//Make sure the session is set
if(!(isset($_SESSION))){
    session_start();
}

//fetch the debug status
$set = new settings;
$status = $set->fetch();


if($status['debug'] == true && $_SESSION['admin'] >= '2'){

//salt unhashed
$salt_raw = 'This is a salt.';

//hash the salt
$salt = '60b448a4b93f07d724baecc1975b00e4b822efa4f6cb997ae0ec92f9f3580e981fe1d7f56f356d16f1451565fcf39929b0c157206fc9522cdc0caefc7b1945d2';//hash('SHA512', $salt_raw);

//echo the salt
echo 'Salt: '.$salt.'</br>';

//salt and hash a password
$password_raw = '';


echo 'Password: '.hash('SHA512', $password_raw.$salt).'<br />';

$fp = fopen('/dev/urandom', 'r');

echo '<br />New Salt: '.hash('SHA512', fread($fp, 256));

}else{
    ?><span class="error">You do not enough have permission to view this page or debug mode is not enabled.</span><?php
}