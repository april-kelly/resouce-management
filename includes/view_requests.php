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
include_once(ABSPATH.'includes/view.php');

$dbc = new db;
$dbc->connect();

$views = new views;

$query = "SELECT * FROM jobs WHERE `requestor` = ".$user_id." && week_of BETWEEN '". $views->weeks[1]."' AND '". $views->weeks[count($views->weeks)]."' ";
$results = $dbc->query($query);
$people = $dbc->query("SELECT `index`,`firstname`,`lastname` FROM people");



//Fix the results indexes to match the database
$new = array();
foreach($people as $person){

    $new[$person["index"]]["name"] = $person["firstname"].' '.$person["lastname"];

}

//Overwrite the results with corrected data
$people = $new;


$dbc->close();

if($results == FALSE){

    if(isset($_SESSION['userid'])){
        echo '<b>No requests found!</b>';
    }else{
        echo '<b>Please Login in to view your requests.</b>';
    }

}else{

    echo '<table border="1" class="data">';

         echo '<tr>';
             echo '<td>Week of:</td>';
             echo '<td>Resource:</td>';
             echo '<td>Manager:</td>';
             echo '<td>Project id:</td>';
             echo '<td>Hours:</td>';
             echo '<td>Priority:</td>';
             echo '<td>Sales Status:</td>';
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

        $times = array(
            "sunday"    => $result['sunday'],
            "monday"    => $result['monday'],
            "tuesday"   => $result['tuesday'],
            "wednesday" => $result['wednesday'],
            "thursday"  => $result['thursday'],
            "friday"    => $result['friday'],
            "saturday"  => $result['saturday']
        );

        $hours = $views->add_times($times);
        $hours = $hours[0].':'.$hours[1];

        echo '<tr>';
        echo '<td>'.$result['week_of'].'</td>';
        echo '<td><a href="./?p=week&amp;w='.$result['resource'].'">'.$people[$result['resource']]['name'].'</a></td>';
        echo '<td><a href="./?p=week&amp;w='.$result['manager'].'">'.$people[$result['manager']]['name'].'</a></td>';
        echo '<td>'.$result['project_id'].'</td>';
        echo '<td>'.$hours.'</td>';
        echo '<td>'.$priority.'</td>';
        echo '<td>'.$status.'</td>';
        echo '</tr>';

    }
    echo '</table>';

}
?>
<br />
<form action="./" method="get" class="button">

    <input type="hidden" name="p" value="user" />
    <input type="submit" value="Go back" />

</form>