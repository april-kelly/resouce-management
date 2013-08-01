<?php
/**
 * Name:       Resource Management View Project Details
 * Programmer: Liam Kelly
 * Date:       8/1/13
 */

//includes
require_once(ABSPATH.'includes/data.php');

$project_id = $_SESSION['project_id'];
unset($_SESSION['project_id']);

$dbc = new db;
$dbc->connect();
$query = 'SELECT * FROM projects WHERE project_id = '.$project_id.' ';
$project = $dbc->query($query);

//Throw out everything but the first result;
$project = $project[0];

echo '<h3>'.$project['title'].'</h3>';
echo '<b>Project id: </b>'.$project['project_id'].'<br />';
echo '<b>Description: </b>';
echo '<p>'.$project['description'].'</p>';
echo '<b>Hours assigned to this project: </b>'.$project['assigned_hours'].'<br />';
echo '<b>Budgeted hours: </b>'.$project['max_hours'].'<br />';

if($project['overage'] == false){
    echo '<em>You cannot request more than the budgeted hours for this project.</em><br />';
}else{
    echo '<em>You can request more hours than are budgeted for this project</em><br />';
}

echo '<br /><a href="./?p=project&id='.$project_id.'">Edit</a>';