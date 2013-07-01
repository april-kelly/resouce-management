<?php
/**
 * Name:       Dump - dumps the session variable
 * Programmer: Liam Kelly
 * Date:       6/28/13
 */

//include the data object
require_once('path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->fetch();

if($status['debug'] == true && $_SESSION['admin'] == '1'){
    echo '<br /><pre>';
    var_dump($_SESSION);
    echo '</pre>';
}