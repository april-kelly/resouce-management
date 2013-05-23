<?php
/**
 * Name:       Settings updater.
 * Programmer: liam
 * Date:       5/21/13
 */

//includes
include_once('/opt/lampp/htdocs/resouce-management/liam/config/');

$set = new settings;
$settings = $set->fetch();

//Reset all of the settings

//Settings for insert.php
$settings['insert_debug']    = $_POST['insert_debug'];
$settings['insert_valid']    = $_POST['insert_valid'];
$settings['insert_sanitize'] = $_POST['insert_sanitize'];
$settings['insert_fail']     = $_POST['insert_fail'];

//Settings for month.php
$settings['month_colors']    = $_POST['month_colors'];
$settings['month_debug']     = $_POST['month_debug'];
$settings['month_excel']     = $_POST['month_excel'];
$settings['month_output']    = $_POST['month_output'];

//Settings for data.php
$settings['db_host']         = $_POST['db_host'];
$settings['db_user']         = $_POST['db_user'];
$settings['db_pass']         = $_POST['db_pass'];
$settings['db_database']     = $_POST['db_database'];

//Global Settings
$settings['weeks']           = $_POST['weeks'];
$settings['location']        = $_POST['location'];

//Update the settings
$set->update($settings);


