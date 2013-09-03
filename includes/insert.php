<!DOCTYPE html>
<html>
<head>

    <title>Debugging information - insert.php</title>

    <link rel="icon" href="./images/btm_favicon.ico" />

</head>
<body>
<?php

/*
	Database Insert Script
	Programmer: Liam Kelly
	Last Modified: 4/09/2013
*/

//start the users session
session_start();

//Include the data object
require_once('../path.php');
require_once('./data.php');
require_once('./config/settings.php');
require_once('./view.php');
require_once('./config/users.php');

//Fetch Settings
$set = new settings;
$settings= $set->fetch();


//Settings and Debugging flags
$debug       = $settings['debug'];		        //flag to enable debugging output				    Default: false
$valid       = $settings['insert_valid'];		//flag to enable user data validation				Default: true
$sanitize    = $settings['insert_sanitize'];	//flag to enable user data sanitation           	Default: true
$fail        = $settings['insert_fail'];		//flag to terminate the insert if something fails   Default: false
$location    = '../';                           //where we will redirect the use upon completion    Default: ../

//Predefined Variables
$total = 0;

//Catch the users input so it can be sent back if necessary
$_SESSION['input'] = $_REQUEST;

//Make sure the user has premission to view debugging info
if(!($_SESSION['admin'] >= 2)){

    //If not disable it
    $debug = FALSE;

}

//connect to the database	
$dbc = new db;
$dbc->connect();

//Determine who is requesting
if(isset($_SESSION['userid'])){
    //A user is logged in
    $requestor = $_SESSION['userid'];
}else{
    //Set the requestor to anonymous
    $requestor = '0';
}

//...and yes, requestor is spell correctly, I used -or because we're dealing with computers

//Debugging title
echo '<h1>Debugging info:</h1><hr />';

//Verifiy the user filled out all inputs correctly
if($valid == TRUE){
	if(!(isset($_REQUEST['project_id']))){ $fail = true; }
	if(!(isset($_REQUEST['manager']))){ $fail = true; }
	if(!(isset($_REQUEST['start_date']))){ $fail = true; }
	if(!(isset($_REQUEST['resource']))){ $fail = true; }
	if(!(isset($_REQUEST['sales_status']))){ $fail = true; }
	if(!(isset($_REQUEST['priority']))){ $fail = true; }
}

if($fail == TRUE){ echo '<i class="error">Verification issues.</i><br />'; }

//sanitize the user inputs
if($sanitize = TRUE){
	
    $week_of            = $dbc->sanitize($_REQUEST['start_date']);
	$project_id   		= $dbc->sanitize($_REQUEST['project_id']);
	$manager     		= $dbc->sanitize($_REQUEST['manager']);
	$resource    		= $dbc->sanitize($_REQUEST['resource']);
    $requestor          = $dbc->sanitize($requestor);
	$sales_status 		= $dbc->sanitize($_REQUEST['sales_status']);
	$priority     		= $dbc->sanitize($_REQUEST['priority']);
	
	//sanitize, fill and the hours array
	$hours = array(
		"sunday"    	=> $dbc->sanitize($_REQUEST['sunday']),
		"monday"   	    => $dbc->sanitize($_REQUEST['monday']),
		"tuesday"   	=> $dbc->sanitize($_REQUEST['tuesday']),
		"wednesday" 	=> $dbc->sanitize($_REQUEST['wednesday']),
		"thursday"  	=> $dbc->sanitize($_REQUEST['thursday']),
		"friday"    	=> $dbc->sanitize($_REQUEST['friday']),
		"saturday"  	=> $dbc->sanitize($_REQUEST['saturday']),
        "total"         => '',
		);

    //Add up all the hours
        $hours['total'] = $hours['total'] +
        $hours['sunday'] +
        $hours['monday'] +
        $hours['tuesday'] +
        $hours['wednesday'] +
        $hours['thursday'] +
        $hours['friday'] +
        $hours['saturday'];
}


    //Fix any fractional times
    foreach($hours as $key => $value){

        if(preg_match('/\./', $value)){
            //This means the user enter a fractional time like 5.5 instead of 5:30
            $hour = floor($value);
            $min = round(60*($value-$hour));
            $value = $hour.':'.$min;
            $hours[$key] = $value;
        }

    }

    //Setup the views class so we can call the time fixer
    $view = new views;

    //Make sure all times are HH:MM
    foreach($hours as $key => $value){

        $hours[$key] = $view->fix_times($value);

    }

    //Get rid of the 'total' key before we serialize
    $total = $hours['total'];
    unset($hours['total']);
    $time = serialize($hours);


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


//check for in valid user inputs
if($valid == TRUE){

	echo "<h3>Entered vaildation mode:</h3>";
	
	//check for a valid sales status
	if(!(is_bool($sales_status))){
		$location = "../?p=request&r=bool";
		echo "Invaild sales status <br />";
		$fail = true;
	}
	
	//check for a valid project manager
	if(!(is_numeric($_REQUEST['manager'])) && !(strlen($_REQUEST['manager']) >= '11' )){
        $location = "../?p=request&r=manager";
		echo "Invaild Project Manager <br />";
		$fail = true;
	}
	
	//check for a valid project id
	if(!(is_numeric($_REQUEST['project_id'])) && !(strlen($_REQUEST['project_id']) >= '11' )){
        $location = "../?p=request&r=projectid";
		echo "Invaild Project id <br />";
		$fail = true;
	}
	
    //ensure the start date is a sunday
    if(!(date('w', strtotime($week_of)) == '0')){
        $location = "../?p=request&r=weekstart";
       	echo "Start date not a sunday <br />";
       	$fail = true;
    }
        
	//check for an empty priority
	if(!(is_numeric($_REQUEST['priority'])) or
	   !(strlen($_REQUEST['priority']) >= '1' )){
        $location = "../?p=request&r=priority";
		echo "Empty Priority <br />";
		$fail = true;
	}

    //Check for a locked user
    $users = new users;
    $results = $users->select($resource);

    if(!($results[0]['lock_start'] == '0000-00-00')){

        if($results[0]['lock_start'] <= $week_of or $results[0]['lock_end'] >= $week_of){

            //The user is locked
            echo "User is locked<br />";

            $fail = true;
            $location = '../?p=request&r=locked';

        }

    }


        
}

if($fail == TRUE){ echo '<i class="error">Validation issues</i><br />'; }

//Verify project
$project = $dbc->query('SELECT * FROM projects WHERE project_id = '.$project_id.' ');

if(!(empty($project))){

    //Add the total for this request to the project's already assigned hours
    $total = $total + $project[0]['assigned_hours'];

    //The project exists
    if($total > $project[0]['max_hours']){

        //Project is over budget
        if($project[0]['overage'] == true){

            //This project is allowed to be over budget
            echo '<br />The project is over budget, but overage is enabled<br />';

            //Make sure the scrip has not failed yet
            if(!($fail == TRUE)){
                $fail = false;
            }


        }else{

            //This project is not allowed to be over budget
            $fail = true;
            echo '<br />Overage not allowed<br />';
            $location = "../?p=request&r=nooverage";

        }

    }else{

        //The requested number of hours does not create overage
        echo "<br />The number of hours is okay<br />";

        //Make sure the scrip has not failed yet
        if(!($fail == TRUE)){
            $fail = false;
        }
    }



}else{

    //The project does not exist, fail,
    //$location = "../?p=request&r=badproject";
    //$fail = true;

}

//Make sure $total is in HH:MM
$total = $view->fix_times($total);


//Insert Query
$query = "INSERT INTO `jobs`
		(`index`,
		`project_id`,
		`manager`,
		`resource`,
		`requestor`,
		`week_of`,
		`sunday`,
		`monday`,
		`tuesday`,
		`wednesday`,
		`thursday`,
		`friday`,
		`saturday`,
		`priority`,
		`sales_status`)
		VALUES
		(NULL,
		'".$project_id."',
		'".$manager."',
		'".$resource."',
		'".$requestor."',
		'".$week_of."',
		'".$hours['sunday']."',
		'".$hours['monday']."',
		'".$hours['tuesday']."',
		'".$hours['wednesday']."',
		'".$hours['thursday']."',
		'".$hours['friday']."',
		'".$hours['saturday']."',
		'".$priority."',
		'".$sales_status."')";

//Project update query
$update = "UPDATE `projects` SET `assigned_hours` = '".$total."' WHERE `index` = ".$project[0]['index']."";

//Query
if($fail == false){
    $dbc->insert($query);
    $dbc->insert($update);
    echo '<br /><i class="success">Attempted to insert. </i><br />';
}else{
    echo '<br /><i class="error">Insert not attempted. </i><br />';
}

//Disconnect
$dbc->close();

//Redirect to the main page
if($debug == true){

    echo '<hr><h3>Query:</h3>'.$query.'<hr /><a href="../">Click here to continue =></a>';

}else{

    header('Location: '.$location);

}

?>
    </body>
</html>