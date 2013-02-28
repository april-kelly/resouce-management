  <table border="1">


<?php

//include the data object
include('data.php');

//Connect to the database
$dbc = new db;
$dbc->connect();
	
//Fetch the list of resources
$people = $dbc->query('SELECT * FROM people');	//Get the table of people

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

//echo out the table header
echo '<tr>';
echo '<td>Resource</td>';
foreach($weeks as $weeks){
	echo '<td>'.$weeks.'</td>';
}
echo '</tr>';

//Start processing for each person
foreach($people as $people){
	
	//Get the list of projects for each person
	$project = $dbc->query("SELECT * FROM test WHERE resource='".$people['index']."' ");
	
	var_dump($project);
	
	//Variables
	$past_week = '';
	$i = '0';
	$sort = $project;
	$hours = '';
	
	//Make sure the person actually has project(s)
	if(!(empty($project))){
		
			//Start echoing out the person's row
			echo '<tr>';
			echo '<td>'.$people['name'].'</td>';
	
			//Go through each project
			foreach($project as $project)
			{
				//Determine if the week of: label and table header should be spit out
				if(!($past_week == $project['week_of'])){
					
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
							
							//echo out the hours by week
							echo '<td>'.$hours.'</td>';
			
		
				/*//Add one to the increment operator
				$j = $i + 1;
			
				//See if another record exists
				if(array_key_exists($j, $sort)){
			
					//If another record exists see if it is of the same week as the current record
					if(!($project['week_of'] == $sort[$j]['week_of'])){
						//echo '</tr><table>';
					}
			
				}else{
					//Echo a 0 if the person has no hours for that week
					echo '<td>0</td>';
				}*/
				
			//End the person's row
			echo '</tr>';
			
		}
		
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
</table>
