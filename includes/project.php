<?php

//includes
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}
require_once(ABSPATH.'includes/data.php');

//Start the session
if(!(isset($_SESSION))){
    session_start();
}

$project_id = $_SESSION['project_id'];
//unset($_SESSION['project_id']);

$dbc = new db;
$dbc->connect();
$query = 'SELECT * FROM projects WHERE project_id = '.$project_id.' ';
$project = $dbc->query($query);


//Make sure there are actually results
if(!(empty($project))){

    //Throw out everything but the first result
    $project = $project[0];



    echo '<h3>Edit a project: </h3>';
    echo '<form action="./?p=project" method="get">';
    echo '<input type="hidden" name="p" value="project" />';
    echo '<input type="hidden" name="id" value="'.$project['project_id'].'" />';
    echo '<label for="title">Title: </label><input type="text" name="title" value="'.$project['title'].'"/><br />';
    echo '<label for="title">Project ID: </label><input type="text" name="project_id" value="'.$project['project_id'].'" /><br />';
    echo '<label for="description">Description: </label><br />';
    echo '<textarea name="description">'.$project['description'].'</textarea><br />';
    echo '<label for="budget">Hours Budget: </label><input type="text" name="max_hours" value="'.$project['max_hours'].'"/><br />';
    echo '<input type="hidden" name="overage" value="FALSE" />';
    echo '<label for="overage">All over budget? </label><input type="checkbox" name="overage" value="'.$project['overage'].'"/><br /><br />';
    echo '<input type="submit" name="submit" value="Update" />';
    echo '</form>';


}else{

    echo '<h3>Could not find the requested project.</h3>';

}

//var_dump($_REQUEST);

if(isset($_REQUEST['submit'])){
    
//Sanitize inputs
$title        = $dbc->sanitize($_REQUEST['title']);
$project_id   = $dbc->sanitize($_REQUEST['project_id']);
$description  = $dbc->sanitize($_REQUEST['description']);
$max_hours    = $dbc->sanitize($_REQUEST['max_hours']);
$overage      = $dbc->sanitize($_REQUEST['overage']);

$index = $project['index'];

$insert = "UPDATE `resources`.`projects` SET
            `project_id` = '$project_id',
             `title`      = '$title',
             `description` = '$description',
             `max_hours`  = '$max_hours',
             `overage`    = '$overage'
            WHERE `index` = $index";

$dbc->insert($insert);

$dbc->close();

    header('location: ./?p=project&id='.$project_id);
}
