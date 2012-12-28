<?php
include('data.php');

//create array to temporarily grab variables
$input_arr = array();
//grabs the $_POST variables and adds slashes
foreach ($_POST as $key => $input_arr) {
    $_POST[$key] = addslashes($input_arr);
}

$project_id = $_REQUEST['project_id'];
$manager = $_REQUEST['manager'];
$start_date = $_REQUEST['start_date'];
if(!(isset($_REQUEST['end_date']))){
 $end_date = $_REQUEST['start_date'];
}else{
$end_date = $_REQUEST['end_date'];
}
$time = $_REQUEST['time'];
$resource = $_REQUEST['resource'];
$sales_status = $_REQUEST['sales_status'];

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
		
$dbc = new db;

$dbc->connect();
$dbc->insert($query);
$dbc->close();
//HALT25
?>