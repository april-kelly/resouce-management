<?php
/**
 * Name:       Settings updater.
 * Programmer: liam
 * Date:       5/21/13
 */

//Settings file location
$location = './settings.bin';

//Unserialize the settings
$settings = unserialize($location);

//Settings

    //month.php
    if(isset($_POST['month_debug']))
    {
        $settings['month_debug'] = $_POST['month_debug'];
    }



/*    if(isset($_POST['month_colors'])){ $settings['month_colors'] = $_POST['month_colors']; }
    if(isset($_POST['month_excel'])){ $settings['month_excel'] = $_POST['month_excel']; }
    if(isset($_POST['month_output'])){ $settings['month_output'] = $_POST['month_output']; }


    //insert.php
    $settings['insert_debug']   =;
    $settings['insert_valid']   =;
    $settings['insert_sanitize']=;
    $settings['insert_fail']    =;

    //data.php
    $settings['db_host']        =;
    $settings['db_user']        =;
    $settings['db_pass']        =;
    $settings['db_database']    =;
*/

//serialize the settings
$settings = serialize($settings);

//save the settings to file
file_put_contents($location, $settings);



