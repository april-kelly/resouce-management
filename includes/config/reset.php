<?php

//Settings rest file
//NOTE *****Remove before production******

//includes
include_once('../../path.php');
include_once(ABSPATH.'includes/config/settings.php');

$set = new settings;
$set->create();

echo "Attempted settings rebuild/reset!";
header('location: ../../?p=home');

