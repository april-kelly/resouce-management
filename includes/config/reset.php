<?php

//Settings rest file
//NOTE *****Remove before production******

//includes
include_once('../../path.php');
include_once(ABSPATH.'includes/config/settings.php');

$set = new settings;


$rebuild = array();
$rebuild['db_host']         = 'localhost';
$rebuild['db_user']         = 'root';
$rebuild['db_pass']         = 'kd0hdf';
$rebuild['db_database']     = 'resources';
$rebuild['server_domain']   = 'localhost';
$rebuild['server_dir']      = '/resouce-management/';

//rebuilds the settings.php file
$set->rebuild($rebuild);


//Recreates the settings.json file
$set->create();

echo "Attempted settings rebuild/reset!";
header('location: ../../?p=home');

