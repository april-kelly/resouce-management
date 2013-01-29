<?php
//Force csv download (if applicable)
   $file = "resources.csv";
   if(isset($_REQUEST['csv'])){
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: text/csv"); 
    header("Content-disposition: attachment; filename=\"".$file."\"");
   }else{
?>
<html>
<head>
	<title>Bluetent Resource Management Program</title>
</head>
<body>
<style>
body{
	text-align: center;
}
table{
	margin-left: auto;
	margin-right: auto;
}
</style>

<table border="1">
<tr>
	<td>
	  <a href="?c=1&o=1"><img src="./images/up.png" title="Order by Index ascending" /></a>
	  <b>Index:</b>
	  <a href="?c=1&o=2"><img src="./images/down.png" title="Order by Index descending" /></a>
	</td>
	
	<td>
	  <a href="?c=2&o=1"><img src="./images/up.png" title="Order by Project ID ascending" /></a>
	  <b>Project ID:</b>
	  <a href="?c=2&o=2"><img src="./images/down.png" title="Order by Project ID descending" /></a>
	</td>
	
	<td>
	  <a href="?c=3&o=1"><img src="./images/up.png" title="Order by Manager ascending" /></a>
	  <b>Manager:</b>
	  <a href="?c=3&o=2"><img src="./images/down.png" title="Order by Manager descending" /></a>
	</td>
	
	<td>
	  <a href="?c=4&o=1"><img src="./images/up.png" title="Order by Start Date ascending" /></a>
	  <b>Start Date:</b>
	  <a href="?c=4&o=2"><img src="./images/down.png" title="Order by Start Date descending" /></a>
	</td>
	
	<td>
	  <a href="?c=5&o=1"><img src="./images/up.png" title="Order by End Date ascending" /></a>
	  <b>End Date:</b>
	  <a href="?c=5&o=2"><img src="./images/down.png" title="Order by End Date descending" /></a>
	</td>
	
	<td>
	  <a href="?c=6&o=1"><img src="./images/up.png" title="Order by Time ascending" /></a>
	  <b>Time:</b>
	  <a href="?c=6&o=2"><img src="./images/down.png" title="Order by Time descending" /></a>
	</td>
	
	<td>
	  <a href="?c=7&o=1"><img src="./images/up.png" title="Order by Resource ascending" /></a>
	  <b>Resource:</b>
	  <a href="?c=7&o=2"><img src="./images/down.png" title="Order by Resource descending" /></a>
	</td>
	
	<td>
	  <a href="?c=8&o=1"><img src="./images/up.png" title="Order by Sales Status ascending" /></a>
	  <b>Sales Status:</b>
	  <a href="?c=8&o=2"><img src="./images/down.png" title="Order by Sales Status descending" /></a>
	</td>
	
	<td>
	 <a href=""><img src=
	</td>
</tr>
<?php
   }
   	//preset variables
   	$column = '';
   	$order = '';
   	
   		
	//the base query
	$query = 'SELECT * FROM `projects` ';
   	
	//Preformed Queries (for ordering)
	if(isset($_REQUEST['c']) && isset($_REQUEST['o'])){
		switch($_REQUEST['c']){
		
		case 1:
		 $column = "`index`";
		break;
	
		case 2:
		 $column = "`project_id`";
		break;
	
		case 3:
		 $column = "`manager`";
		break;
	
		case 4:
		 $column = "`start_date`";
		break;
	
		case 5:
		 $column = "`end_date`";
		break;
	
		case 6:
		 $column = "`time`";
		break;
	
		case 7:
		 $column = "`resource`";
		break;
	
		case 8:
		 $column = "`sales_status`";
		break;
	
		default:
		 $column = '';
		break;
	
		}
	
		//order in asc or desc
		if($_REQUEST['o'] == '1'){
			$order = 'ASC';
		}elseif($_REQUEST['o'] == '2'){
			$order = 'DESC';
		}
		
		//add the order commands
		$query .= "ORDER BY $column ";
		$query .= $order;
	
	}
	
	//csv header
	$csv = "Index:,Project_id:,Manager:,Start_Date:,End_Date:,Time:,Resource:,Sales Status:\r\n";
	
	//Include the data object
	include('data.php');
	
	//connection for projects
	$dbc = new db;
	
	$dbc->connect();
	$project = $dbc->query($query);
	$dbc->close();
	
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
	//echo out the results
	foreach($project as $project)
	{
		
		//make boolean sales_status human readable
		if($project['sales_status'] == '0'){
			$status = "Opportunity";
		}else{
			$status = "Sold";
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
		
		//table view
		if(!(isset($_REQUEST['csv'])))
		{
			echo '<tr>';
			echo '<td>',$project['index'],'</td>';
			echo '<td>',$project['project_id'],'</td>';
			
			//echo out manager
			if($manager == true){
				echo '<td>',$people[$project['manager']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
			}
			
			echo '<td>',$project['start_date'],'</td>';
			echo '<td>',$project['end_date'],'</td>';
			echo '<td>',$project['time'],'</td>';
			
			//echo out resource
			if($resource == true){
				echo '<td>',$people[$project['resource']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
			}
			
			
			echo '<td>',$status,'</td>';
			echo '</tr>';
		}
		
		//csv view
		if(isset($_REQUEST['csv']))
		{
			echo $project['index'].',';
			echo $project['project_id'].',';
			
			//echo out manager
			if($manager == true){
				echo $people[$project['manager']]['name'].',';
			}else{
				echo "[error]".',';
			}
			
			echo $project['start_date'].',';
			echo $project['end_date'].',';
			echo $project['time'].',';
			
			//echo out resource
			if($resource == true){
				echo $people[$project['resource']]['name'].',';
			}else{
				echo "[error]".',';
			}
			
			echo $status."\r\n";
		}


	}

	//Don't echo out the table if the user is downloading a csv version
	if(!(isset($_REQUEST['csv']))){
?>
<table>
<form action="?&" method="get">
	<label><b>Download: </b></label>
	<input type="submit" value="Download as csv" name="csv">
</form>
</body>
</html>
<?php
	}
?>
