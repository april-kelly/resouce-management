<?php
/**
 * Name:       Settings updater.
 * Programmer: liam
 * Date:       5/21/13
 */

//includes
include_once('/opt/lampp/htdocs/resouce-management/liam/config/settings.php');

$set = new settings;
$settings = $set->fetch();
$set->create();


//Output Debugging info on request
if(isset($_POST['dump'])){
?>
    <h1>Settings Debugging information</h1>
    <hr />
    <b>JSON:</b>
    <pre>
<?php
    echo file_get_contents($set->location);
?>
   </pre>
   <b>Associative Array:</b>
   <pre>
<?php
    var_dump($set->fetch());
?>
   </pre>
   <hr />
   <a href="./admin.php">Go back</a>
<?php

}

//Rest the settings file to defaults on request
if(isset($_POST['rebuild'])){
    $set->create();
    header('location: ./admin.php?rebuilt');
}


//Reset all of the settings

/*//Settings for insert.php
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
*/

//Update the settings
$fail = $set->update($settings);

//Redirect the user back to the settings menu
if($fail == TRUE){
    //header('location: ./admin.php?success');
}else{
    //header('location: ./admin.php?failure');
}