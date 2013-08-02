<?php

//includes
require_once('../path.php');
require_once(ABSPATH.'includes/data.php');

//Get the project list
$dbc = new db;
$dbc->connect();
$q = $dbc->sanitize($_GET['q']);
$projects = $dbc->query("SELECT * FROM projects WHERE project_id LIKE '%".$q."%'");

//Stuff to send with every request
echo '<br />';
echo '<label>Suggestions: </label>';
echo '<br />';

if(!(empty($projects))){

    $i = 1;
    foreach($projects as $project){

        echo $project['project_id']." ".$project['title'];

        if(count($projects) > $i){
            echo '<br />';
        }
        $i++;
    }

}else{

    echo "Could not find project.";

}
