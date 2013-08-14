<?php
/**
 * Name:       Resource Management Project Settings Update and Creation tool
 * Programmer: Liam Kelly
 * Date:       8/6/13
 */

//Includes
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}
require_once(ABSPATH.'includes/config/settings.php');

//Session
if(!(isset($_SESSION))){
    session_start();
}

//Fetch the settings
$set = new settings;
$settings = $set->fetch();

echo '<pre>';

//Update each setting
foreach($_REQUEST as $key => $value){

    if(isset($settings[$key])){

        //The setting exists, so we will update it

        switch($value){

            CASE 'TRUE':

                $settings[$key] = TRUE; //this ensures a boolean is saved

                break;

            CASE 'FALSE':

                $settings[$key] = FALSE; //this ensures a boolean is saved

                break;

            DEFAULT:

                $settings[$key] = $value; //normal method (for strings)

                break;
        }

    }


}



echo '</pre>';


