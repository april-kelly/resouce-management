<?php
/**
 * Name:       Resource Management settings.php Modifier
 * Programmer: Liam Kelly
 * Date:       7/29/13
 */


//Define settings to change

$settings = file_get_contents('./settings.php');


//Create the salt
//Get some random
$fp = fopen('/dev/urandom', 'r');

//Hash the randomness
$salt = hash('SHA512', fread($fp, 512));

$patterns = array(
    1 => '/sqlhost/',
    2 => '/sqluser/',
    3 => '/sqlpass/',
    4 => '/sqldb/',
    5 => '/serverip/',
    6 => '/serverdomain/',
    7 => '/serversalt/',
    8 => '/This is a sample for mod.php do not modify \(to edit settings change ..\/config\/settings.php\)/'
);
$replacements = array(
    1 => 'localhost',
    2 => 'root',
    3 => 'kd0hdf',
    4 => 'resources',
    5 => '127.0.0.1',
    6 => 'localhost/resouce-management/',
    7 => $salt,
    8 => ''
);

$new_settings = preg_replace($patterns, $replacements,  $settings);

file_put_contents('./settings.test.php', $new_settings);
