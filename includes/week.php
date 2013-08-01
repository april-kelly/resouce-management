<?php

/*
	Name: Resource Weekly Expanded View
	Description: Echos out projects by resource by week
	Programmer: Liam Kelly
	Date Last Modified: 03-21-2013

*/

//Includes
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

$set = new settings;
$settings = $set->fetch();


//Settings
$show = $settings['weeks'];


//Variables
$column = '';
$order = '';
$past_week = '';

//build a list of weeks

//get the current or last sunday
if(date( "w", date("U")) == '0'){
    $current = date('Y-m-d');
}else{
    $current = date('Y-m-d', strtotime('Last Sunday', time()));
}

$weeks = array();
$weeks[1] = $current;
for($i = 2; $i <= $show; $i++){
    $weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
$week = $weeks; //create a copy of $weeks

//Database connection
$dbc = new db;

$dbc->connect();

$result		 = $dbc->query('SELECT * FROM people');
$person 	 = $dbc->sanitize($_SESSION['person']);
$project_id  = $dbc->sanitize($_SESSION['project_id']);

unset($_SESSION['person']);
unset($_SESSION['project_id']);

if(!(empty($person))){
    $projects    = $dbc->query('SELECT * FROM `jobs` WHERE resource = '.$person.' ');
}else{
    $projects    = $dbc->query('SELECT * FROM `jobs` WHERE project_id = '.$project_id.' ');
}
//Delete section
if(isset($_SESSION['d'])){
    $query = "DELETE FROM jobs WHERE `index` = '".$_SESSION['d']."'";
    $dbc->delete($query);
    unset($_SESSION['d']);
    header('location: ./?p=week&w='.$_SESSION['person'].'&e=1');
}

//fix indexes of the people table
$people = array();

foreach($result as $result){
    $people[$result['index']]['index'] = $result['index'];
    $people[$result['index']]['name'] = $result['firstname'];
    $people[$result['index']]['type'] = $result['type'];
}

echo "<h3>Weekly expanded view for ".$people[$person]['name'].": </h3>";

//sort by week
foreach($week as $week){

    $project = $projects; //reset the destroyed project variable

    //sort by project
    if(!(empty($project))){
        foreach($project as $project){

            //echo out project if found
            if($project['week_of'] == $week){

                if($past_week !== $project['week_of']){
                    if($past_week !== ''){ echo '</table><br /><br />'; }
                    echo '<b>'.$week.'</b>';
                    ?>
                    <table border="1" class="data">
                    <tr>
                        <td>Resource:</td>
                        <td>Manager</td>
                        <td>Requestor</td>
                        <td>Project id:</td>
                        <td>Priority</td>
                        <td>Sunday</td>
                        <td>Monday</td>
                        <td>Tuesday</td>
                        <td>Wednesday</td>
                        <td>Thursday</td>
                        <td>Friday</td>
                        <td>Saturday</td>
                        <td>Sales Status</td>
                        <?php
                        if(isset($_SESSION['edit']) && isset($_SESSION['userid'])){
                            echo '<td>Delete</td>';
                        }
                        ?>
                    </tr>
                <?php
                }


                //make boolean sales_status human readable
                if($project['sales_status'] == '0'){
                    $status = "Opportunity";
                }else{
                    $status = "Sold";
                }

                //make numeric priority human readable
                if($project['priority'] == '0'){
                    $priority = "Very High";
                }elseif($project['priority'] == '1'){
                    $priority = "High";
                }elseif($project['priority'] == '2'){
                    $priority = "Medium";
                }elseif($project['priority'] == '3'){
                    $priority = "Low";
                }

                //Verify project manager exists
                if(isset($people[$project['manager']])){
                    $manager = true;
                }else{
                    $manager = false;
                }

                //Verify resource exists
                if(isset($people[$project['resource']])){
                    $resource = true;
                }else{
                    $resource = false;
                }

                //Verify requestor exists
                if(isset($people[$project['requestor']])){
                    $requestor = true;
                }else{
                    $requestor = false;
                }

                //Begin echo out the record
                echo '<tr/>';

                //echo out the resource
                if($resource == true){
                    echo '<td>',$people[$project['resource']]['name'],'</td>';
                }else{
                    echo '<td><span class="error">[Error]</span></td>';
                }

                //echo out manager
                if($manager == true){
                    echo '<td>',$people[$project['manager']]['name'],'</td>';
                }else{
                    echo '<td><span class="error">[Error]</span></td>';
                }

                //echo out the requestor
                if($requestor == true){
                    echo '<td>',$people[$project['requestor']]['name'],'</td>';
                }else{
                    echo '<td><span class="error">[Error]</span></td>';
                }

                //Unserialize the time
                $time = unserialize($project['time']);

                //echo out the rest of the table
                echo '<td><a href="./?p=view_project&id='.$project['project_id'].'">',$project['project_id'],'</a></td>';
                echo '<td>',$priority,'</td>';
                echo '<td>',$time['sunday'],'</td>';
                echo '<td>',$time['monday'],'</td>';
                echo '<td>',$time['tuesday'],'</td>';
                echo '<td>',$time['wednesday'],'</td>';
                echo '<td>',$time['thursday'],'</td>';
                echo '<td>',$time['friday'],'</td>';
                echo '<td>',$time['saturday'],'</td>';
                echo '<td>',$status,'</td>';

                if(isset($_SESSION['edit'])){
                    echo '<td><a href="./?p=week&w='.$_SESSION['person'].'&e=1&d='.$project['index'].'"><img src="./includes/images/x32.png"></a></td>';
                }

                echo '</tr>';

                $past_week = $week;

            }



        }

    }else{
        if($past_week == ''){ echo "<b>Sorry, no records were found</b>"; }
        $past_week = $week;
    }

    //end the last table
    if($week == end($weeks)){
        echo '</table>';
    }
}

//Close database connection
$dbc->close();

//if the user is logged in allow them to edit records
if(isset($_SESSION['userid']) && !(isset($_SESSION['edit']))){
    echo '<br /><a href="./?p=week&w='.$_SESSION['person'].'&e=1">Edit</a><br />';
}elseif(isset($_SESSION['edit'])){
    echo '<br /><a href="./?p=week&w='.$_SESSION['person'].'&e=0">Done editing?</a><br />';
}

if($_SESSION['edit'] == '0'){
    unset($_SESSION['edit']);
    header('location: ./?p=week&w='.$_SESSION['person']);
}

?>