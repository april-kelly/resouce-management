<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 1/31/2013
*/

//Include the data object
include('data.php');

//preset variables
$fail = false; //flag to prevent running query

//Values
$project_id = '997';
$manager    = '1';
$resource   = '2';
$week_of    = '2013-02-12';
$time       = serialize(array(
	"sunday"     => '1',
	"monday"     => '3',
	"tuesday"    => '12',
	"wednesday"  => '10',
	"thursday"   => '53',
	"friday"     => '7',
	"saturday"   => '0',
));
$sales_status = '1';
$priority   = '1';

//Query
$query = "INSERT INTO `resources`.`test`
		(`index`,
		`project_id`,
		`manager`,
		`resource`,
		`week_of`,
		`time`,
		`sales_status`,
		`priority`)
		VALUES
		(NULL,
		'".$project_id."',
		'".$manager."',
		'".$resource."',
		'".$week_of."',
		'".$time."',
		'".$sales_status."',
		'".$priority."')";

//query;
insert($query);

//Redirect the user to list.php
if(isset($_REQUEST['debug']) || $fail == true){
 echo '<br />';
 
 if(isset($_REQUEST['debug'])){
  echo '<b>Debug mode:</b> on<br />';
  echo '<br /><b>Query:</b><br />'.$query;
 }else{
  echo '<span style="color: red;"><b>ERROR: </b>The insert statement has failed. </span><br />';
 }
 
 echo '<br />';
}else{
 //header('Location: ./list.php');
}

?>
