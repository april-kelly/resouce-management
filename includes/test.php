<?php
//Make sure the ABSPATH constant is defined
if(!(defined('ABSPATH'))){
require_once('../path.php');
}

//Needed to execute
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH .'includes/config/settings.php');
require_once(ABSPATH.'includes/view.php');

$test = new views;
$table = $test->build_list_weeks('2', ' ');
var_dump($table);
