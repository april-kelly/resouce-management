<?php

/*
	Title: Resource Totaling
	Description: This script totals all of each resource's hours for each week
	Programmer: Liam Kelly
*/

//Include the data object
include('data.php');

//Setup the database connection
$dbc = new db;
$dbc->connect();

//Setup the table and row arrays
$table = array();
$row = array();

//Step 1: Fetch a list of all of the resources
	$resource = $dbc->query("SELECT * FROM people");

//Step 2: Determine the weeks to search for
	foreach($resource as $resource){
		/*
		for($i = 1; $i <= 8; $i++){
			
			//The week to start from
			$start_week = "2013-02-05";
		
			//Add 7 days to the start week
			$date = new DateTime($start_week);
			$date->add(new DateInterval('P07D'));
			$week = $date->format('Y-m-d') . "\n";
			$start_week = $week;

			//Step 3: Search for each week and resource in the database
			//$results = $dbc->query("SELECT * FROM test WHERE resource='".$resource['index']."' AND week_of='".$week."'");
			echo "SELECT * FROM test WHERE resource='".$resource['index']."' AND week_of='".$week."'\r\n";
			//If there are results total up the hours for each
			if(empty($results)){
				
				//$row['week'] = $i;
				//$row['hours'] = '0';
				
			}else{
				
				$row['week'] = $i;
				 
				$hours = unserialize($results['time']);
				
				echo $hours['sunday']
					       +$hours['monday']
					       +$hours['tuesday']
					       +$hours['wednesday']
					       +$hours['thursday']
					       +$hours['friday']
					       +$hours['saturday'];
				
			}
		
			//Step 4: Stuff all of the data into the $table variable
			//$table = $table.$row;
			//var_dump($row);
		}
		//*/
	}
				$results = $dbc->query("SELECT * FROM test WHERE resource='2' AND week_of='2013-02-12'");
				foreach($results as $results){
				$hours = unserialize($results['time']);
				var_dump($hours);
				echo $hours['sunday']
					       +$hours['monday']
					       +$hours['tuesday']
					       +$hours['wednesday']
					       +$hours['thursday']
					       +$hours['friday']
					       +$hours['saturday'];
					       echo "<br />";
				}



//Close the database connection
$dbc->close();

?>
