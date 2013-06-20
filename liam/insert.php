<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 4/09/2013
*/

//Include the data object
require_once(ABSPATH.'/data.php');

//Fetch Settings
$settings = unserialize(file_get_contents('./admin/settings.bin'));

//Settings and Debugging flags
$debug       = $settings['insert_debug'];		//flag to prevent running query					    Default: false
$valid       = $settings['insert_valid'];		//flag to enable user data validation				Default: true
$sanitize    = $settings['insert_sanitize'];	//flag to enable user data sanitation           	Default: true
$fail        = $settings['insert_fail'];		//flag to terminate the insert if something fails   Default: false
     
//connect to the database	
$dbc = new db;
$dbc->connect();

//Verifiy the user filled out all inputs correctly
if($valid = TRUE){
	if(!(isset($_REQUEST['project_id']))){ $fail = true; }
	if(!(isset($_REQUEST['manager']))){ $fail = true; }
	if(!(isset($_REQUEST['start_date']))){ $fail = true; }
	//if(!(isset($_REQUEST['time']))){ $fail = true; }
	if(!(isset($_REQUEST['resource']))){ $fail = true; }
	if(!(isset($_REQUEST['sales_status']))){ $fail = true; }
	if(!(isset($_REQUEST['priority']))){ $fail = true; }
}

if($fail = TRUE){ echo "verification"; }

//sanitize the user inputs
if($sanitize = TRUE){
	
        $week_of                = $dbc->sanitize($_REQUEST['start_date']);
	$project_id   		= $dbc->sanitize($_REQUEST['project_id']);
	$manager     		= $dbc->sanitize($_REQUEST['manager']);
	$resource    		= $dbc->sanitize($_REQUEST['resource']);
	$sales_status 		= $dbc->sanitize($_REQUEST['sales_status']);
	$priority     		= $dbc->sanitize($_REQUEST['priority']);
	
	//sanitize, fill and serialize the hours array
	$hours = serialize(array( 
		"sunday"    	=> $dbc->sanitize($_REQUEST['sunday']),
		"monday"   	=> $dbc->sanitize($_REQUEST['monday']),
		"tuesday"   	=> $dbc->sanitize($_REQUEST['tuesday']),
		"wednesday" 	=> $dbc->sanitize($_REQUEST['wednesday']),
		"thursday"  	=> $dbc->sanitize($_REQUEST['thursday']),
		"friday"    	=> $dbc->sanitize($_REQUEST['friday']),
		"saturday"  	=> $dbc->sanitize($_REQUEST['saturday']),
		));
}

//If the week_of is not in Y-m-d format fix it
$week_of = date("Y-m-d", strtotime($week_of));

//make the sales_status be boolean
$sales_status = 1;
if($_REQUEST['sales_status'] == '1'){
	$sales_status = true;
}
	
if($_REQUEST['sales_status'] == '0'){
	$sales_status = false;
}


//verifiy the resource and manger requested exists
if($valid = TRUE){


}


//check for in valid user inputs
if($valid = TRUE){

	echo "<b>Entered vaildation mode:</b><br>";
	
	//check for a valid sales status
	if(!(is_bool($sales_status))){
		//header("Location: ./index.php?&bool");
		echo "Invaild sales status <br />";
		$fail = true;
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
		//header("Location: ./index.php?&manager");
		echo "Invaild Project Manager <br />";
		$fail = true;
	}
	
	//Ensure the project manager exists in the database
	if(!(verify('people', 'index', $_REQUEST['manager']))){
		echo "Project manager does not exist in the database <br />";
		$fail = true;
	}
	
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
		//header("Location: ./index.php?&projectid");
		echo "Invaild Project id <br />";
		$fail = true;
	}
	
	//check for a valid resource
	if(!(is_numeric($_REQUEST['resource']))){//fix this
		//header("Location: ./index.php?&resource");
		echo "Invaild Resouce <br />";
		$fail = true;
	}
	
	//Ensure resource exists in the database
	if(!(verify('people', 'index', $_REQUEST['resource']))){
		echo "Resource does not exist in the Database <br />";
		$fail = true;
	}
	
	//check for a vaild prority
	if(!(is_numeric($_REQUEST['priority']))){
		echo "Priority not vaild <br />";
		$fail = true;
	}
	
	//check for a time
	/*if(!(isset($_REQUEST['time']))){
		//header("Location: ./index.php?&time");
		echo "No time <br />";
		$fail = true;
	}*/
	
	//check for an empty start date
	if($week_of == ''){
		header("Location: ./index.php?&nodate");
		echo "Empty start date <br />";
		$fail = true;
	}
	
        //ensure the start date is a sunday
        if(!(date('w', strtotime($week_of)) == '0')){
        	header("Location: ./index.php?&weekstart");
        	echo "Start date not a sunday <br />";
        	$fail = true;
        }
        
	//check for an empty priority
	if(!(is_numeric($_REQUEST['priority'])) && 
	   !(strlen($_REQUEST['priority']) >= '1' )){
		header("Location: ./index.php?&priority");
		echo "Empty Priority <br />";
		$fail = true;
	}
        
}
if($fail = TRUE){ echo "validation"; }

//Query(new)
$query = "INSERT INTO `jobs`
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
if($fail = FALSE){
 $dbc->insert($query);
 echo "attempted insert";
}

//Disconnect
$dbc->close();

//Debugging and redirection
if(isset($_REQUEST['debug']) || $fail = TRUE || $debug = TRUE){

 //Echo out the Debugging page
 if($debug = TRUE && $fail = FALSE){
  echo '<h2>Debug mode:</h2><br /><hr>';
  echo '<b>Query:</b><br />'.$query.'<hr>';
  echo '<b>Flags:</b><br />Fail: '.$fail.'<br />Debug: '.$debug.'<br />Valid: '.$valid.'<br />Sanitize: '.$sanitize.'<hr />';
  echo '<b>Values:</b><br />project_id: '.$project_id.'<br />manager: '.$manager.'<br />week_of: '.$resource.'<br />hours: '.$week_of.'<br />priority: '.$priority.'<br />sales_status: '.$sales_status.'<hr />';
  echo '<p style="text-align: center;"><a href="./dashboard.php" style="text-align:right;">Click Here to Continue >></a></p>'; 
 }                           
 
 //Echo out an error message if the user tries to enter debugging mode with out setting the flag first               
 if(isset($_REQUEST['debug']) && $fail = FALSE){
  echo '<h2>Debug mode:</h2><br />For security reasons debug mode must be enable by setting the $debug flag to true.<hr>';  
 }
 
 //Aleart the user that their query has failed                                                      
 if($fail = TRUE){
  echo '<span style="color: red;"><h2>ERROR: </h2>The insert statement has failed. </span><br /><hr />';
  echo '<br /><br /><h3>Debugging info:</h3><br />';
  echo '<b>Query:</b><br />'.$query.'<hr>';
  echo '<b>Flags:</b><br />Fail: '.$fail.'<br />Debug: '.$debug.'<br />Valid: '.$valid.'<br />Sanitize: '.$sanitize.'<hr />';
  echo '<b>Values:</b><br />project_id: '.$project_id.'<br />manager: '.$manager.'<br />week_of: '.$resource.'<br />hours: '.$week_of.'<br />priority: '.$priority.'<br />sales_status: '.$sales_status.'<hr />';
  echo '<p style="text-align: center;"><a href="./dashboard.php" style="text-align:right;">Click Here to Continue >></a></p>'; 
 }

//otherwise redirect the user to the results page
}else{
 header('Location: ./dashboard.php');
}

?>