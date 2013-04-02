<html>
<head>
	<title>Bluetent Resource Management Program</title>
	<link rel="stylesheet" href="./styles/styles.css" type="text/css" />
</head>
<body>

<?php

/*
	Name: Resource Weekly Expanded View
	Description: Echos out projects by resource by week
	Programmer: Liam Kelly
	Date Last Modified: 03-21-2013

*/

//Includes
include('data.php');

//Settings
$show = '8';


//Variables
$column = '';
$order = '';
$past_week = '';
  	
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
$week = $weeks; //create a copy of $weeks

//Database connection
$dbc = new db;

$dbc->connect();

$result		 = $dbc->query('SELECT * FROM people');
$person 	 = $dbc->sanitize($_REQUEST['p']);
$projects        = $dbc->query('SELECT * FROM `jobs` WHERE resource = '.$person.' ');

//fix indexes of the people table
$people = array();

foreach($result as $result){
	$people[$result['index']]['index'] = $result['index'];
	$people[$result['index']]['name'] = $result['name'];
	$people[$result['index']]['type'] = $result['type'];
}

echo "<h3>Weekly expanded view for ".$people[$person]['name']."</h3>";

//sort by week
foreach($week as $week){

	$project = $projects; //reset the destroyed project variable
	
	//sort by project
	if(!(empty($project))){
	foreach($project as $project){
		
		//echo out project if found
		if($project['week_of'] == $week){
			
			if($past_week !== $project['week_of']){
				if($past_week !== ''){ echo '</table><br /><br />'; }
				echo $week;
				?>
				<table border="1">
				<tr>
				<td>Resource:</td>
				<td>Manager</td>
				<td>Project id:</td>
				<td>Priority</td>
				<td>Sunday</td>
				<td>Monday</td>
				<td>Tuesday</td>
				<td>Wednesday</td>
				<td>Thursday</td>
				<td>Friday</td>
				<td>Saturday</td>
				<td>Sales Status</td>
				</tr>
				<?php
		 	}
		
		
		 	//make boolean sales_status human readable
		 	if($project['sales_status'] == '0'){
		 		$status = "Opportunity";
		 	}else{
		 		$status = "Sold";
		 	}
		
		 	//make numeric priority human readable
		 	if($project['priority'] == '0'){
		 		$priority = "Very High";
		 	}elseif($project['priority'] == '1'){
				$priority = "High";
		 	}elseif($project['priority'] == '2'){
		 		$priority = "Medium";
		 	}elseif($project['priority'] == '3'){
		 		$priority = "Low";
		 	}
                
		 	//Verify project manager exists
		 	if(isset($people[$project['manager']])){
		 		$manager = true;
		 	}else{
		 		$manager = false;
		 	}
		
		 	//Verify resource exists
		 	if(isset($people[$project['resource']])){
		 		$resource = true;
		 	}else{
		 		$resource = false;
			}
		
			//Begin echo out the record
			echo '<tr/>';
			
			//echo out the resource
			if($resource == true){
				echo '<td>',$people[$project['resource']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
			}
			
			//echo out manager
			if($manager == true){
				echo '<td>',$people[$project['manager']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
			}
			
		 	//Unserialize the time
		 	$time = unserialize($project['time']);
		 	
		 	//echo out the rest of the table
			echo '<td>',$project['project_id'],'</td>';
			echo '<td>',$priority,'</td>';
			echo '<td>',$time['sunday'],'</td>';
			echo '<td>',$time['monday'],'</td>';
			echo '<td>',$time['tuesday'],'</td>';
			echo '<td>',$time['wednesday'],'</td>';
			echo '<td>',$time['thursday'],'</td>';
			echo '<td>',$time['friday'],'</td>';
			echo '<td>',$time['saturday'],'</td>';
			echo '<td>',$status,'</td>';
			
			echo '</tr>';
			
			$past_week = $week;
			
		}
		
	}
	
	}else{
		if($past_week == ''){ echo "<h3>Sorry, no records were found</h3>"; }
		$past_week = $week;
	}
	
}

//Close database connection
$dbc->close();
?>
</body>
</html>

