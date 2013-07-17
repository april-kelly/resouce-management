<?php
/**
 * Name:       Resource Management Base Template (using output buffering).
 * Programmer: Liam Kelly
 * Date:       7/17/13
 */

//Start output buffering
ob_start();

//Start the users session
session_start();

//Includes
require_once('../../path.php');                         //Sets the ABSPATH constant
require_once(ABSPATH.'includes/data.php');              //Data class
require_once(ABSPATH.'includes/config/settings.php');   //Settings class
require_once(ABSPATH.'includes/config/users.php');      //Users class

//Lookup the requested page in the database
$dbc = new db;
$dbc->connect();
$page = $dbc->sanitize($_REQUEST['p']);
$results = $dbc->query('SELECT * FROM pages WHERE name = \''.$page.'\'');

//If the request page does not exist show the home page
if(!(count($results) == '1')){

    //Show the homepage
    $results = $dbc->query('SELECT * FROM pages WHERE name = \'home\'');

}

    //Display Section

    //Check the user's clearance versus the page's
    if(!($results[0]['security_class'] <= $_SESSION['security_class'])){

        //The user does not have clearance
        $results = $dbc->query('SELECT * FROM pages WHERE name = \'home\'');

    }

    //Start another output buffer for the page
    ob_start();

    //Require the header

    //Require the body

    //Require the footer

    //Flush the buffer
    ob_end_flush();


//close the database connection
$dbc->close();

//Flush the output buffer
ob_end_flush();

