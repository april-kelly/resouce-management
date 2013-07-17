<?php
/**
 * Name:       Resource Management Database Driven Page Builder (using output buffering).
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

//Setup the database connection
$dbc = new db;
$dbc->connect();

//Lookup the requested page
if(isset($_REQUEST['p'])){
    $p = $_REQUEST['p'];
}else{
    $p = 'home';
}
$request = $dbc->sanitize($p);
$query  = 'SELECT * FROM pages WHERE name = \''.$request.'\'';
$page = $dbc->query($query);

//If the request page does not exist show the home page
if(!(count($page) == '1')){

    //Show the homepage
    $page = $dbc->query('SELECT * FROM pages WHERE name = \'home\'');

}


    //Display Section

    //Check the user's clearance versus the page's
    if(!(isset($_SESSION['security_class']))){

        //The user is not logged in
        $_SESSION['security_class'] = '0'; //The lowest possible class

    }
    if(!($page[0]['security_class'] <= $_SESSION['security_class'])){

        //The user does not have clearance
        $page = $dbc->query('SELECT * FROM pages WHERE name = \'home\'');

    }

    //Stack another output buffer for the page
    ob_start();

        //Setup values to pass to main template
        $_SESSION['page_location'] = $page[0]['location'];
        $_SESSION['main_id'] = $page[0]['main_id'];

        //include the main template
        include_once('./template.php');

    //Flush the buffer
    ob_end_flush();


//close the database connection
$dbc->close();

//Flush the output buffer
ob_end_flush();

