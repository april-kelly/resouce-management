
<?php
/**
 * Name:       Resource Management Application Search
 * Programmer: Liam Kelly
 * Date:       8/6/13
 */

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

$query_p = "SELECT * FROM `people` WHERE `firstname` LIKE '%".$search."%'  OR `lastname` LIKE '%".$search."%'  OR `email` LIKE '%".$search."%'  ";
$people = $dbc->query($query_p);
echo $query_p;
if(!(empty($people))){

    foreach()

}


if(empty($results)){

   echo 'No results found';

}else{

    foreach($results as $result){

        echo '<a href="?p=view_project&id='.$result['project_id'].'">'.$result['project_id'].' '.$result['title'].'</a><br />';
        echo $result['description'].'<br /><br />';

    }

}
