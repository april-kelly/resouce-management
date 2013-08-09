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


if(isset($_REQUEST['id'])){


    $project_id = $_SESSION['project_id'];
    //unset($_SESSION['project_id']);

    $dbc = new db;
    $dbc->connect();
    $query = 'SELECT * FROM projects WHERE project_id = '.$project_id.' ';
    $project = $dbc->query($query);

    //Make sure the user actually wants to edit
    if(isset($_REQUEST['e'])){

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
            echo '<label for="overage">Allow over budget? </label><input type="checkbox" name="overage" value="'.$project['overage'].'"/><br /><br />';
            echo '<input type="submit" name="submit" value="Update" />';
            echo '</form>';


        }else{

            echo '<h3>Could not find the requested project.</h3>';

        }

    }else{

        //Throw out everything but the first result
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

        echo '<br /><a href="./?p=project&e=&id='.$project_id.'">Edit</a>';

    }

}else{

    //If the id is not set, show the project creation form

    echo '<h3>Add a project: </h3>';
    echo '<form action="./?p=project" method="get">';
    echo '<input type="hidden" name="p" value="project" />';
    echo '<input type="hidden" name="id" value="" />';
    echo '<label for="title">Title: </label><input type="text" name="title" value=""/><br />';
    echo '<label for="title">Project ID: </label><input type="text" name="project_id" value="" /><br />';
    echo '<label for="description">Description: </label><br />';
    echo '<textarea name="description"></textarea><br />';
    echo '<label for="budget">Hours Budget: </label><input type="text" name="max_hours" value=""/><br />';
    echo '<input type="hidden" name="overage" value="FALSE" />';
    echo '<label for="overage">Allow over budget? </label><input type="checkbox" name="overage" value=""/><br /><br />';
    echo '<input type="submit" name="submit" value="Add" />';
    echo '</form>';


}


if(isset($_REQUEST['submit'])){

    //Sanitize inputs
    $title        = $dbc->sanitize($_REQUEST['title']);
    $project_id   = $dbc->sanitize($_REQUEST['project_id']);
    $description  = $dbc->sanitize($_REQUEST['description']);
    $max_hours    = $dbc->sanitize($_REQUEST['max_hours']);
    $overage      = $dbc->sanitize($_REQUEST['overage']);

    //Update an existing project
    if($_REQUEST['submit'] == 'Update'){

        $index = $project['index'];

        $update = "UPDATE `resources`.`projects` SET
                        `project_id` = '$project_id',
                         `title`      = '$title',
                         `description` = '$description',
                         `max_hours`  = '$max_hours',
                         `overage`    = '$overage'
                        WHERE `index` = $index";

        $dbc->insert($update);


        header('location: ./?p=project&id='.$project_id);

    }

    //Add a new project
    if($_REQUEST['submit'] == 'Add' ){

        $insert = 'INSERT INTO `resources`.`projects` (
            `index`,
            `project_id`,
            `title`,
            `description`,
            `max_hours`,
            `assigned_hours`,
            `overage`)
             VALUES (
             NULL,
             \''.$project_id.'\',
             \''.$title.'\',
             \''.$description.'\',
             \''.$max_hours.'\',
             \'0:00:00\',
             \''.$overage.'\')';

        $dbc->insert($insert);

        //Send the user to the view page for their project
        header('location: ./?p=project&id='.$project_id);

    }

}

//Close the database connection if it was started
if(is_object($dbc)){

    $dbc->close();

}

