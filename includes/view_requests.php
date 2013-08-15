<?php
/**
 * Name:       View Requests
 * Programmer: Liam Kelly
 * Date:       8/13/13
 */

if(!(isset($_SESSION))){
    session_start();
}
$user_id = $_SESSION['userid'];

if(!(defined('ABSPATH'))){
    include_once('../path.php');
}

include_once(ABSPATH.'includes/data.php');

$dbc = new db;
$dbc->connect();

$query = "SELECT * FROM jobs WHERE `requestor` = ".$user_id;
$results = $dbc->query($query);
$people = $dbc->query('SELECT `index`,`firstname`,`lastname` FROM people');



//Fix the results indexes to match the database
$new = array();
foreach($people as $person){

    $new[$person["index"]]["name"] = $person["firstname"].' '.$person["lastname"];

}

//Overwrite the results with corrected data
$people = $new;


$dbc->close();

if($results == FALSE){

    echo '<b>No requests found!</b>';

}else{

    echo '<table border="1">';

         echo '<tr>';
             echo '<td>Index:</td>';
             echo '<td>Resource:</td>';
             echo '<td>Manager</td>';
             echo '<td>Requestor</td>';
             echo '<td>Project id:</td>';
             echo '<td>Priority</td>';
             /*echo '<td>Sunday</td>';
             echo '<td>Monday</td>';
             echo '<td>Tuesday</td>';
             echo '<td>Wednesday</td>';
             echo '<td>Thursday</td>';
             echo '<td>Friday</td>';
             echo '<td>Saturday</td>';*/
             echo '<td>Sales Status</td>';
         echo '</tr>';

    foreach($results as $result){

        //make boolean sales_status human readable
        if($result['sales_status'] == '0'){
            $status = "Opportunity";
        }else{
            $status = "Sold";
        }

        //make numeric priority human readable
        if($result['priority'] == '0'){
            $priority = "Very High";
        }elseif($result['priority'] == '1'){
            $priority = "High";
        }elseif($result['priority'] == '2'){
            $priority = "Medium";
        }elseif($result['priority'] == '3'){
            $priority = "Low";
        }

        echo '<tr>';
        echo '<td>'.$result['index'].'</td>';
        echo '<td>'.$people[$result['resource']]['name'].'</td>';
        echo '<td>'.$people[$result['manager']]['name'].'</td>';
        echo '<td>'.$people[$result['requestor']]['name'].'</td>';
        echo '<td>'.$result['project_id'].'</td>';
        echo '<td>'.$priority.'</td>';
      /*echo '<td>'.$result['sunday'].'</td>';
        echo '<td>'.$result['monday'].'</td>';
        echo '<td>'.$result['tuesday'].'</td>';
        echo '<td>'.$result['wednesday'].'</td>';
        echo '<td>'.$result['thursday'].'</td>';
        echo '<td>'.$result['friday'].'</td>';
        echo '<td>'.$result['saturday'].'</td>';*/
        echo '<td>'.$status.'</td>';
        echo '</tr>';

    }
    echo '</table>';

}