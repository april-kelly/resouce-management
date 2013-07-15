<?php

//Settings rest file
//NOTE *****Remove before production******

//includes
include_once('../../path.php');
include_once(ABSPATH.'includes/config/settings.php');

$set = new settings;
$set->create();
var_dump($set->fetch());