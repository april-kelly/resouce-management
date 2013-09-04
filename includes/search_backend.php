<?php
/**
 * Name:       Resource Management Application Search
 * Programmer: Liam Kelly
 * Date:       8/6/13
 */
//Session
if(!(isset($_SESSION))){
    session_start();
}


//Includes
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}
require_once(ABSPATH.'includes/data.php');

$dbc = new db;
$dbc->connect();
$search = $dbc->sanitize($_REQUEST['q']);

$query = "SELECT * FROM `projects` WHERE `title` LIKE '%".$search."%'  OR `project_id` LIKE '%".$search."%'  OR `description` LIKE '%".$search."%'  ";
$results = $dbc->query($query);

$query_p = "SELECT * FROM `people` WHERE `firstname` LIKE '%".$search."%'  OR `lastname` LIKE '%".$search."%'  OR `email` LIKE '%".$search."%' LIMIT 0,12";
$people = $dbc->query($query_p);

echo '<br />';

echo '<div id="people">'."\r\n";
echo '<b>People:</b><br /><br />'."\r\n";

if(!(empty($people))){

   foreach($people as $person){

       echo '<a href="?p=week&amp;w='.$person['index'].'">'.$person['firstname'].' '.$person['lastname'].'</a><br />'."\r\n";

   }

}else{

    echo 'No people found';

}

echo '</div>'."\r\n";


echo '<div id="projects">'."\r\n";
echo '<br /><b>Projects: </b><br /><br />'."\r\n";

if(empty($results)){


   echo 'No projects found';

}else{

    foreach($results as $result){

        echo '<a href="?p=project&amp;id='.$result['project_id'].'">'.$result['project_id'].' '.$result['title'].'</a><br />'."\r\n";
        echo $result['description'].'<br /><br />';

    }

}

//Credits easter egg.
if($_REQUEST['q'] == 'credits'){

    echo '<br />Written mostly by Liam Kelly, with help from: Jeremey Cerise, Rodney O\'Bryne and Ethan Hinson.'."\r\n";

}

//Session Destroy
if($_REQUEST['q'] == 'Destroythesession.'){

    echo '<br />Session Destroyed';
    session_destroy();

}

echo '</div>'."\r\n";

//Close the Database connection
$dbc->close();
