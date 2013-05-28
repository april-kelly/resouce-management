<?php
/**
 * Name:       Settings updater.
 * Programmer: liam
 * Date:       5/21/13
 */

//includes
include_once('/opt/lampp/htdocs/resouce-management/liam/config/settings.php');

//fetch the settings
$set = new settings;
$settings = $set->fetch();


//output debugging info on request
if(isset($_REQUEST['dump'])){
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

//update each of the settings
foreach($_REQUEST as $key => $value){

    echo $key.' => '.$value."<br />\r\n";

    if(isset($settings[$key])){

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

//update the settings
$fail = $set->update($settings);

//Redirect the user back to the settings menu
if($fail == TRUE){
    header('location: ./admin.php?success');
}else{
    header('location: ./admin.php?failure');
}