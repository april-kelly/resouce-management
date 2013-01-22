<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 1/3/2013
*/

//Include the data object
include('data.php');

//If the request is only for one day
/*if(!(isset($_REQUEST['end_date']))){
 $end_date = $_REQUEST['start_date'];
}else{
 $end_date = $_REQUEST['end_date'];
}
*/

//preset variables
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$fail = false;				//flag to prevent running query

//check for an empty start date
if($start_date == ""){
 header("Location: ./index.php?nodate");
}

//check for an empty end date
if($end_date == ""){
	 $end_date = $_REQUEST['start_date'];
}


//convert dates to Y-m-d format
echo $end_date = date("Y-m-d", strtotime($end_date));
echo $start_date = date("Y-m-d", strtotime($start_date));

//connect to the database	
$dbc = new db;
$dbc->connect();

//sanitize the user inputs
$project_id   = $dbc->sanitize($_REQUEST['project_id']);
$manager      = $dbc->sanitize($_REQUEST['manager']);
$start_end    = $dbc->sanitize($start_date);
$end_date     = $dbc->sanitize($end_date);
$time         = $dbc->sanitize($_REQUEST['time']);
$resource     = $dbc->sanitize($_REQUEST['resource']);
$sales_status = $dbc->sanitize($_REQUEST['sales_status']);

//verifiy the resource or manger requested existed
if(!(verify('people', 'index', $_REQUEST['resource']))){ $fail = true; }
if(!(verify('people', 'index', $_REQUEST['manager']))){ $fail = true; }

//Verifiy the user filled out all inputs correctly
if(!(isset($_REQUEST['project_id']))){ $fail = true; }
if(!(isset($_REQUEST['manager']))){ $fail = true; }
if(!(isset($_REQUEST['start_date']))){ $fail = true; }
if(!(isset($_REQUEST['time']))){ $fail = true; }
if(!(isset($_REQUEST['resource']))){ $fail = true; }
if(!(isset($_REQUEST['sales_status']))){ $fail = true; }

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
		'".$project_id."',
		'".$manager."',
		'".$start_date."',
		'".$end_date."',
		'".$time."',
		'".$resource."',
		'".$sales_status."')";


//Query
if($fail = false){
 $dbc->insert($query);
}

//Disconnect
$dbc->close();

//Redirect the user to list.php
//header('Location: ./list.php');

?>