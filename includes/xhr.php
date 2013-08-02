<?php

//includes
require_once('../path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//Fetch settings
$set = new settings;
$settings = $set->fetch();

//Get the project list
$dbc = new db;
$dbc->connect();
$q = $dbc->sanitize($_GET['q']);
$projects = $dbc->query("SELECT * FROM projects WHERE project_id LIKE '%".$q."%'");

//Stuff to send with every request
echo '<br />';
echo '<label>Suggestions: </label>';
echo '<br />';
echo '<span class="info">';
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

    //Easter eggs
    if($q == 'logo'){

        echo '<br /><img src="/includes/images/logo.gif" />';

    }

    if($q == 'credits'){

        echo '<br />Written mostly by Liam Kelly, with help from: Jeremey Cerise, Rodney O\'Bryne and Ethan Hinson.';

    }

    if($q == 'dontbeevil'){

        //Only allow login override in beta (where it has uses).
        if($settings['production'] == false){

            session_start();
            session_destroy();
            session_start();

            $_SESSION['userid'] = '0';
            $_SESSION['name'] = 'Hacker';
            $_SESSION['admin'] = '3';
            $_SESSION['security_class'] = '0';
            $_SESSION['beta'] = true;


        }

    }

}
echo '</span>';
