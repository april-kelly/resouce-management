<?php
//includes
require_once('../path.php');
require_once(ABSPATH.'includes/view.php');

$view = new views;
$test = $view->build_list_weeks(2);

var_dump($test);