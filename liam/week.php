<html>
<head>
	<title>Bluetent Resource Management Program</title>
	<link rel="stylesheet" href="./styles/styles.css" type="text/css" />
</head>
<body>

<?php
//Includes
include('data.php');

//preset variables
$column = '';
$order = '';
$show = '8';
  	
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

	
	//connection for projects
	$dbc = new db;
	
	$dbc->connect();
	if(isset($_REQUEST['p'])){
	$person = $dbc->sanitize($_REQUEST['p']);
	$project = $dbc->query('SELECT * FROM `test` WHERE resource = '.$person.' ');
	}
	
	//connection for people
	$dbc = new db;
	
	$dbc->connect();
	$result = $dbc->query("SELECT * FROM people");
	$dbc->close();
	                                     
	//echo out csv if the user is attempting to download it
	if(isset($_REQUEST['csv'])){
		echo $csv;
	}
	
	//fix the $people results to have an index matching that of the database
	$people = array();
	
	foreach($result as $result){
		$people[$result['index']]['index'] = $result['index'];
		$people[$result['index']]['name'] = $result['name'];
		$people[$result['index']]['type'] = $result['type'];
	}

	$past_week = '';
	$i = '0';
	$sort = $project;
	//echo out the results
	foreach($project as $project)
	{
		//Determine if the week of: label and table header should be spit out
		if(!($past_week == $project['week_of'])){
		echo '<br /><b>Week of: '.$project['week_of'].'</b><br />';
		
		//Spit out the table header
		?>
		<table border="1">
		<tr>
		 <td>Resource:</td>
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
		 <?php if(isset($_REQUEST['edit'])){ echo '<td></td>'; ?>
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
		
		//unserialize the hours
		$time = unserialize($project['time']);
		
		//table view
		if(!(isset($_REQUEST['csv'])))
		{
			
			for($x = $count; $i >= 1; $x--){
				
				if($project['week_of'] == $weeks[$i]){
					echo '<tr>';
			
			//echo out the resource
			if($resource == true){
				echo '<td>',$people[$project['resource']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
			}

			
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
			
			//show delete options if editing is enabled
			if(isset($_REQUEST['edit'])){
				echo '<td><a href="?rm='.$project['index'].'"><img src="./images/x.jpg" height="23" width="32" title="Delete this request"></a></td>';
			}
			
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
			
			//Make the past week equal this week before moving to the next record
			$past_week = $project['week_of'];
			$i++;
			
				}
			}

		}
	}
	}

?>

</body>
</html>

