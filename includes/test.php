<?php
//Make sure the ABSPATH constant is defined
if(!(defined('ABSPATH'))){
require_once('../path.php');
}

//Needed to execute
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH .'includes/config/settings.php');
require_once(ABSPATH.'includes/view.php');

$set = new settings();
$set->add('new', 'setting', 'This is a comment');