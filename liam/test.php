<?php
//include the data object
include('data.php');

//Connect to the database
$dbc = new db;
$dbc->connect();
	

//Fetch the list of resources
$people = $dbc->query('SELECT * FROM people');	//Get the table of people

foreach($people as $people){
	
	$project = $dbc->query("SELECT * FROM test WHERE resource='".$people['index']."' ");	//Get the table of people
	
	$past_week = '';
	$i = '0';
	$sort = $project;
	$hours = '';
	if(!(empty($project))){
	//echo out the results
	foreach($project as $project)
	{
		//Determine if the week of: label and table header should be spit out
		if(!($past_week == $project['week_of'])){
			echo '<br /><b>Week of: '.$project['week_of'].'</b><br />';
			echo 'Resource: '.$people['name'].'<br />';
		
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
						+ $time['saturday'];
			
		
			//Add one to the increment operator
			$j = $i + 1;
			
			//See if another record exists
			if(array_key_exists($j, $sort)){
			
				//If another record exists see if it is of the same week as the current record
				if(!($project['week_of'] == $sort[$j]['week_of'])){
					echo '</tr><table>';
				}
			
			}else{
				echo '</tr><table>';
			}
		}
		
		//echo out the hours
		echo 'Hours: '.$hours.'<br />';
		
		//empty the hours variable
		$hours = '';
			
		//Make the past week equal this week before moving to the next record
		$past_week = $project['week_of'];
		$i++;
		
	}
	}


	
}
	
	
	
//close the database connection
$dbc->close();
	
?>
