<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 1/31/2013
*/

//Include the data object
include('data.php');

//Preset variables:
//$start_date = $_REQUEST['start_date'];
//$end_date = $_REQUEST['end_date'];
$week_of = $_REQUEST['start_date'];  //rename to weekof upon completion of debugging

//Debugging Flags:
$debug = true; 		//flag to prevent running query
$valid = true;		//flag to prevent user data validation
$sanitize = false;	//flag to prevent user data sanitation (use with caution)
$dump = true;		//flag to enable userdate dumping ($debug must be true)
$fail = false;		//flag to alert the user the script has failed


//check for invalid user inputs
if($debug == false){
		
	//make the sales_status be boolean
	$sales_status = 1;
	if($_REQUEST['sales_status'] == '1'){
		$sales_status = true;
	}
	
	if($_REQUEST['sales_status'] == '0'){
		$sales_status = false;
	}
	
	//check for a valid sales status
	if(!(is_bool($sales_status))){
		header("Location: ./index.php?&bool");
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
		header("Location: ./index.php?&manager");
	}
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
		header("Location: ./index.php?&projectid");
	}
	
	//check for a valid resource
	if(!(is_numeric($_REQUEST['resource'])) && !(strlen($_REQUEST['resource']) >= '11' )){
		header("Location: ./index.php?&resource");
	}
	
	//check for a time
	if(!(isset($_REQUEST['time']))){
		header("Location: ./index.php?&time");
	}
	
	//check for an empty start date
	if($start_date == ''){
		header("Location: ./index.php?&nodate");
	}
	
}
	//check for an empty end date
	/*if($end_date == ""){
		$end_date = $_REQUEST['start_date'];
	}*/

//convert dates to Y-m-d format
/*$start_date = date("Y-m-d", strtotime($start_date));
$end_date = date("Y-m-d", strtotime($end_date));
*/
$week_of = date("Y-m-d", strtotime($week_of));

//connect to the database	
$dbc = new db;
$dbc->connect();

//fill the hours array
$hours = serialize(array( 
		"sunday"    => $_REQUEST['sunday'],
		"monday"    => $_REQUEST['monday'],
		"tuesday"   => $_REQUEST['tuesday'],
		"wednesday" => $_REQUEST['wednesday'],
		"thursday"  => $_REQUEST['thursday'],
		"friday"    => $_REQUEST['friday'],
		"saturday"  => $_REQUEST['saturday'],
		));
		

//sanitize the user inputs
if($sanitize == false){
	$project_id   = $dbc->sanitize($_REQUEST['project_id']);
	$manager      = $dbc->sanitize($_REQUEST['manager']);
	//$start_end    = $dbc->sanitize($start_date);
	//$end_date     = $dbc->sanitize($end_date);
	//$time         = $dbc->sanitize($_REQUEST['time']);
	//$hours	      = $dbc->sanitize($hours);
	$resource     = $dbc->sanitize($_REQUEST['resource']);
	$sales_status = $dbc->sanitize($_REQUEST['sales_status']);
	$priority     = '';//$dbc->sanitize($_REQUEST['priority']);
}

//verifiy the resource and manger requested exists
if($valid == false){
	if(!(verify('people', 'index', $_REQUEST['resource']))){ $fail = true; }
	if(!(verify('people', 'index', $_REQUEST['manager']))){ $fail = true; }
}

//Verifiy the user filled out all inputs correctly
if($valid == false){
	if(!(isset($_REQUEST['project_id']))){ $fail = true; }
	if(!(isset($_REQUEST['manager']))){ $fail = true; }
	if(!(isset($_REQUEST['start_date']))){ $fail = true; }
	if(!(isset($_REQUEST['time']))){ $fail = true; }
	if(!(isset($_REQUEST['resource']))){ $fail = true; }
	if(!(isset($_REQUEST['sales_status']))){ $fail = true; }
}

//Query(old)
/*$query = "INSERT INTO `resources`.`projects`
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
*/

//Query(new)
$query = "INSERT INTO `resources`.`test`
		(`index`,
		`project_id`,
		`manager`,
		`resource`,
		`week_of`,
		`time`,
		`priority`,
		`sales_status`)
		VALUES
		(NULL,
		'".$project_id."',
		'".$manager."',
		'".$resource."',
		'".$week_of."',   
		'".$hours."',
		'".$priority."',
		'".$sales_status."')";

//Query
if($fail == false){
 $dbc->insert($query);
}

//Disconnect
$dbc->close();

//Redirect the user to list.php
if(isset($_REQUEST['debug']) || $fail == true || $debug == true){
 echo '<br />';
 
 if($debug == true){
  echo '<h2>Debug mode:</h2><br /><hr>';
  echo '<b>Query:</b><br />'.$query.'<hr>';
  echo '<b>Flags:</b><br />Fail: '.$fail.'<br />Debug: '.$debug.'<br />Valid: '.$valid.'<br />Sanitize: '.$sanitize.'<br />Dump: '.$dump.'<hr />';
  echo '<b>Values:</b><br />project_id: '.$project_id.'<br />manager: '.$manager.'<br />week_of: '.$resource.'<br />hours: '.$week_of.'<br />priority: '.$priority.'<br />sales_status: '.$sales_status.'<hr />';
  echo '<p style="text-align: center;"><a href="./new_list.php" style="text-align:right;">Click Here to Continue >></a><br />(C) Copyright 2013 Liam Kelly</p>';
 }elseif(isset($_REQUEST['debug'])){
  echo '<h2>Debug mode:</h2><br />For security reasons debug mode must be enable by setting the $debug flag to true.<hr>';
 }else{
  echo '<span style="color: red;"><b>ERROR: </b>The insert statement has failed. </span><br />';
 }
 
 echo '<br />';
}else{
 header('Location: ./new_list.php');
}

?>