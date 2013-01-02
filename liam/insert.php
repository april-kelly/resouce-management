<?php
include('data.php');


if(!(isset($_REQUEST['end_date']))){
 $end_date = $_REQUEST['start_date'];
}else{
$end_date = $_REQUEST['end_date'];
}

//echo $_REQUEST['manager'];


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
	
		
$dbc = new db;
$dbc->connect();
$dbc->insert($query);
$dbc->close();
//HALT25
?>