<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 1/3/2013
*/

//Include the data object
include('data.php');

//If the request is only for one day
if(!(isset($_REQUEST['end_date']))){
 $end_date = $_REQUEST['start_date'];
}else{
 $end_date = $_REQUEST['end_date'];
}

//Query
$query = "INSERT INTO `resources`.`projects`
		(`index`,
		`project_id`,
		`manager`,
		`start_date`,
		`end_date`,
		`time`,
		`resource`,
		`sales_status`)
		VALUES
		(NULL,
		'".$_REQUEST['project_id']."',
		'".$_REQUEST['manager']."',
		'".$_REQUEST['start_date']."',
		'".$end_date."',
		'".$_REQUEST['time']."',
		'".$_REQUEST['resource']."',
		'".$_REQUEST['sales_status']."')";

//Run the query on the database		
$dbc = new db;
$dbc->connect();
$dbc->insert($query);
$dbc->close();

//Redirect the user to list.php
header('Location: ./list.php');

?>