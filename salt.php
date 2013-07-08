<?php
/**
 * Name: Salt Generator
 * Programmer: Liam Kelly
 * Date: 7/8/13
 */

//includes
include_once('path.php');


//salt unhashed
$salt_raw = 'This is a salt.';

//hash the salt
$salt = hash('SHA512', $salt_raw);

//echo the salt
echo 'Salt: '.$salt.'</br>';

//salt and hash a password
$password_raw = 'basalt22';

echo 'Password: '.hash('SHA512', $password_raw.$salt).'<br />';


