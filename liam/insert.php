<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 1/3/2013
*/

//Include the data object
include('data.php');

//preset variables
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$fail = false;				//flag to prevent running query


//check for invalid user inputs
	
	//check for a valid sales status
	if(!(is_bool($_REQUEST['sales_status']))){
		header("Location: ./index.php?&bool");
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
		header("Location: ./index.php?&manager");
	}
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
		header("Location: ./index.php?&projectid");
		echo $_REQUEST['project_id'].strlen($_REQUEST['project_id']);
	}
	
	//check for a valid resource
	if(!(is_numeric($_REQUEST['resource'])) && !(strlen($_REQUEST['resource']) >= '11' )){
		header("Location: ./index.php?&resource");
	}
	
	//check for a valid time

	//check for an empty start date
	if($start_date == ""){
		header("Location: ./index.php?&nodate");
	}
	

	//check for an empty end date
	if($end_date == ""){
		$end_date = $_REQUEST['start_date'];
	}

//convert dates to Y-m-d format
$start_date = date("Y-m-d", strtotime($start_date));
$end_date = date("Y-m-d", strtotime($end_date));

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

//verifiy the resource or manger requested exists
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
if($fail == false){
 $dbc->insert($query);
}

//Disconnect
$dbc->close();

//Redirect the user to list.php
if(isset($_REQUEST['debug']) || $faile == true){
 echo '<br />';
 
 if(isset($_REQUEST['debug'])){
  echo '<b>Debug mode:</b> on<br />';
  echo '<br /><b>Query:</b><br />'.$query;
 }else{
  echo '<span style="color: red;"><b>ERROR: </b>The insert statement has failed.</span><br />';
 }
 
 echo '<br />';
}else{
 header('Location: ./list.php');
}

?>