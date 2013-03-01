<html>

 <head>
 
 	<title>Bluetent Resource Management: Monthly View</title>
 	
 	<style>
 	body{
 		text-align: center;
 	}
 	table{
 		margin-left: auto;
 		margin-right: auto;
 	}
 	</style>
 
 </head>
 
 <body>

<table border="1">
<?php

//Define variables
$hours = '';
$show = '12';

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
	$table[$people['index']]['name'] = $people['name'];
	
	for($i = $count; $i >= 1; $i--){
		
		$table[$people['index']][$i] = '0';
		
	}
	
	//Get the list of projects for each person
	$project = $dbc->query("SELECT * FROM test WHERE resource='".$people['index']."' ");


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
							+ $time['saturday'];
								
					$table[$people['index']][$i] = $hours; 
						
					//empty the hours variable
					$hours = '';
					
				}					
					
			}
				
		}
		
		
	}
	
}
//close the database connection
$dbc->close();

//Echo out the table header
echo "\t".'<tr>'."\r\n\r\n";
echo "\t\t".'<td>Resource: </td>'."\r\n";
foreach($weeks as $weeks){
	echo "\t\t".'<td>'.$weeks.'</td>'."\r\n";
}
echo "\t".'</tr>'."\r\n\r\n";

//echo out each of the rows in the table
foreach($table as $table){
	
	echo "\t".'<tr>'."\r\n";
	echo "\t\t".'<td>'.$table['name'].'</td>'."\r\n";
	
	for($i = 1; $i <= $count; $i++){
		echo "\t\t".'<td>';
		
		if($table[$i] == 0) { echo '<span style="background-color: #fff; width: 100%; height: 100%; display: block;">'.$table[$i].'</span>'; }
		if($table[$i] <= 15 && $table[$i] >= 1 ) { echo '<span style="background-color: green; width: 100%; height: 100%; display: block;">'.$table[$i].'</span>'; }
		if($table[$i] <= 25 && $table[$i] >= 16 ) { echo '<span style="background-color: yellow; width: 100%; height: 100%; display: block;">'.$table[$i].'</span>'; }
		if($table[$i] <= 36 && $table[$i] >= 26 ) { echo '<span style="background-color: orange; width: 100%; height: 100%; display: block;">'.$table[$i].'</span>'; }
		if($table[$i] <= 50 && $table[$i] >= 37 ) { echo '<span style="background-color: red; width: 100%; height: 100%; display: block;">'.$table[$i].'</span>'; }
		
		echo '</td>'."\r\n";
	}  
	
	echo "\t".'</tr>'."\r\n\r\n";
	
}
	
?>
</table>

  </body>

</html>
