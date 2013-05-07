<?php

function table(){
//Includes
include_once('data.php');
include_once('./excel/ABG_PhpToXls.cls.php');
include_once('settings.php');

//Settings
$colors = fetch(8);
$debug = fetch(9);

//Others
$color_enable = $debug['color_enable'];
$excel_enable = $debug['excel_enable'];
$show	      = $debug['show'];
$output       = $debug['output'];

//Define variables
$hours = '';

//build a list of weeks

//get the current or last sunday
if(date( "w", date("U")) == '0'){
	$current = date('Y-m-d');
}else{
	$current = date('Y-m-d', strtotime('Last Sunday', time()));
}



$weeks = array();
$weeks[1] = $current;
for($i = 2; $i <= $show; $i++){
	$weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
$count = count($weeks);

//Connect to the database
$dbc = new db;
$connection = $dbc->connect();


//Prevent anything from running if the connection failed
if(is_bool($connection)){
    if($connection = FALSE){
        $fail = TRUE;
    }else{
        $fail = FALSE;
    }
}

if($fail = TRUE){
//Fetch the list of resources
$people = $dbc->query('SELECT * FROM people');	//Get the table of people

//create the table
$i = 0;

//Start building the table
foreach($people as $people)
{
	//Build the table
	$table[$people['index']]['id'] = $people['index'];
	$table[$people['index']]['name'] = $people['name'];
	
	for($i = $count; $i >= 1; $i--){
		
		$table[$people['index']][$i] = '0';
		
	}
	
	//Get the list of projects for each person
	$project = $dbc->query("SELECT * FROM jobs WHERE resource='".$people['index']."' ");


	//Make sure the person actually has projects
	if(!(empty($project))){
			
		foreach($project as $project){
			
			for($i = $count; $i >= 1; $i--){
				
				if($project['week_of'] == $weeks[$i]){
					
					//Process the hours
					
					//unserialize the hours array
					$time = unserialize($project['time']);
					
					//add everything up
					$hours = $hours + $time['sunday']
							+ $time['monday']
							+ $time['tuesday']
							+ $time['wednesday']
							+ $time['thursday']
							+ $time['friday']
							+ $time['saturday'];//*/
								
					//insert the hours into the table
					$table[$people['index']][$i] = $table[$people['index']][$i] + $hours; 
						
					//empty the hours variable
					$hours = '';
					
				}					
					
			}
				
		}
		
		
	}
	
}
//close the database connection
$dbc->close();


}


return array("weeks"=>$weeks,"table"=>$table);
}

	
?>

