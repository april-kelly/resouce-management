<?php
/**
 * Name:       Resource Management Database Cleaning Tool (removes old data)
 * Programmer: Liam Kelly
 * Date:       8/13/13
 */
//Start the user's session if it has not started
if(!(isset($_SESSION))){
    session_start();
}

//Make sure ABSPATH is defined
if(!(defined('ABSPATH'))){
    include_once('../path.php');
}

//Includes
include_once(ABSPATH.'includes/data.php');
include_once(ABSPATH.'includes/config/settings.php');

//Ensure the user is an Admin
if($_SESSION['admin'] >= 1){

    //Set up the database connection
    $dbc = new db;
    $dbc->connect();

    //Clean up the jobs table

        //Step 1: Determine the number of rows
        $query = "SELECT count(*) FROM jobs";
        $size = $dbc->query($query);
        $size = $size[0]['count(*)'];

        //Define the dates to search for
        $date1 = '2013-08-11';
        $date2 = '2013-08-25';

        //Create the array to hold the values
        //We are using a fixed array to allow us to hold roughly 3 times as many rows as a normal array would
        $array = new SplFixedArray($size);

        //Step 2: Fetch all rows which need to be deleted
        $query = "SELECT `index` FROM jobs WHERE `week_of` BETWEEN '".$date1."' AND '".$date2."'";
        $to_delete = $dbc->query($query);

        //Step 3: Delete each row
        foreach($to_delete as $delete){

            $query = "DELETE FROM jobs WHERE `index` = ".$delete['index'];
            echo $query."\r\n";
            //$dbc->query($query);

        }



    //Close the Database Connection
    $dbc->close();

//End of admin only section
}else{

    echo '<span class="error">You must be an administrator to view this page</span>';

}