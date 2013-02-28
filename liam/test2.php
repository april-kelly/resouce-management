  <table border="1">


<?php

//build a list of weeks

//get the current or last sunday
if(date( "w", date("U")) == '0'){
	$current = date('Y-m-d');
}else{
	$current = date('Y-m-d', strtotime('Last Sunday', time()));
}

$weeks = array();
$weeks[1] = $current;
for($i = 2; $i <= 8; $i++){
	$weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
$count = count($weeks);

var_dump($weeks);

//include the data object
include('data.php');

//Connect to the database
$dbc = new db;
$dbc->connect();
	
//Fetch the list of resources
$people = $dbc->query('SELECT * FROM people');	//Get the table of people

//create the table
$i = 0;

//Start building the table
foreach($people as $people)
{
	//Build the table
	$table[$people['index']]['id'] = $people['index'];
	
	for($i = $count; $i >= 0; $i--){
		
		$table[$people['index']][$i] = '';
		
	}
	
	//Get the list of projects for each person
	$project = $dbc->query("SELECT * FROM test WHERE resource='".$people['index']."' ");

	//Make user the person actually has projects
	if(!(empty($project))){
	

			
			foreach($project as $project){
				
				for($i = $count; $i >= 0; $i--){
					
					$table[$people['index']][$count] = ''; 
					
				}
				
			}
		
		
	}
	
}

var_dump($table);
	
	
	
//close the database connection
$dbc->close();
	
?>
</table>
