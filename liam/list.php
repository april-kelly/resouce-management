<?php
//start session
session_start();
//Force csv download
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
<form action="./list.php" method="post">
	<label><b>Page:</b></label>
	<input type="submit" value="First" name="first">
	<input type="submit" value="Previous" name="previous">
	<input type="submit" value="Next" name="next">
	<input type="submit" value="Last" name="Last"><br />
	
	<label><b>Filters: </b><label>
	<select name="by">
	 <option value="">Select One:</option>
	 <option value="ORDER BY">Order by</option>
	 <option value="SORT BY">Sort by</option>
	</select>
	
	<select name="column">
	 <option value="">Select One:</option>
	 <option value="PRIMARY">Index:</option>
	 <option value="project_id">Project_ID:</option>
	 <option value="manager">Manager:</option>
	 <option value="start_date">Start_Date:</option>
	 <option value="end_date">End_Date:</option>
	 <option value="time">Time:</option>
	 <option value="resource">Resource:</option>
	 <option value="sales_status">Sales_Status:</option>
	</select>
	
	<select name="order">
	 <option value="">Select One:</option>
	 <option value="DESC">Descending</option>
	 <option value="ASC">Ascending</option>
	</select>

	<input type="submit" value="Filter" />
</form>

<table border="1">
<tr>
	<td><b>Index:</b></td>
	<td><b>Project_ID:</b></td>
	<td><b>Manager:</b></td>
	<td><b>Start_Date:</b></td>
	<td><b>End_Date:</b></td>
	<td><b>Time:</b></td>
	<td><b>Resource:</b></td>
	<td><b>Sales_Status:</b></td>
</tr>
<?php
   }
	//pagination code
	if(!(isset($_SESSION['start']))){
	$_SESSION['start'] = '0';
	$_SESSION['end'] = '30';
	}

	if(isset($_REQUEST['last'])){
		//$_SESSION['start'] = $_SESSION['start'] - 30;
		//$_SESSION['end'] = $_SESSION['end'] - 30;
	}
	
	if(isset($_REQUEST['first'])){
		$_SESSION['start'] = '0';
		$_SESSION['end'] = '30';
	}
	
	if(isset($_REQUEST['next'])){
		$_SESSION['start'] = $_SESSION['start'] + 30;
		$_SESSION['end'] = $_SESSION['end'] + 30;
	}
	
	if(isset($_REQUEST['previous'])){
		$_SESSION['start'] = $_SESSION['start'] - 30;
		$_SESSION['end'] = $_SESSION['end'] - 30;
	}
	
	if($_SESSION['start'] < 0 or $_SESSION['end'] < 0){
		$_SESSION['start'] = '0';
		$_SESSION['end'] = '30';
	}
	
	
	$query = 'SELECT * FROM projects LIMIT '.$_SESSION['start'].','.$_SESSION['end'].' ';
	
	if(isset($_REQUEST['by']) && isset($_REQUEST['column']) && isset($_REQUEST['order']) ){
		$query = $query.$_REQUEST['by']." ".$_REQUEST['column']." ".$_REQUEST['order'];
	}
	
	//csv header
	$csv = "Index:,Project_id:,Manager:,Start_Date:,End_Date:,Time:,Resource:,Sales_Status:\r\n";
	
	//Include the data object
	include('data.php');
	
	
	//connection for projects
	$dbc = new db;
	
	$dbc->connect();
	$result = $dbc->query($query);
	$dbc->close();
	
	//connection for people
	$dbc = new db;
	
	$dbc->connect();
	$people = $dbc->query("SELECT * FROM people");
	$dbc->close();
	
	//echo out csv if the user is attempting to download it
	if(isset($_REQUEST['csv'])){
		echo $csv;
	}
	
	//var_dump($people);

	//echo out the results
	foreach($result as $result)
	{
		
		//make boolean sales_status human readable
		if($result['sales_status'] == '0'){
			$status = "Opportunity";
		}else{
			$status = "Sold";
		}
		
		//create csv from results
		//$csv = $csv.implode(',',$result)."\r\n";

		//table view
		if(!(isset($_REQUEST['csv']))){
			echo '<tr>';
			echo '<td>',$result['index'],'</td>';
			echo '<td>',$result['project_id'],'</td>';
			echo '<td>',$people[$result['manager']]['name'],'</td>';
			echo '<td>',$result['start_date'],'</td>';
			echo '<td>',$result['end_date'],'</td>';
			echo '<td>',$result['time'],'</td>';
			echo '<td>',$people[$result['resource']]['name'],'</td>';
			echo '<td>',$status,'</td>';
			echo '</tr>';
		}
		
		//csv view
		if(isset($_REQUEST['csv'])){
			echo $result['index'].',';
			echo $result['project_id'].',';
			echo $people[$result['manager']]['name'].',';
			echo $result['start_date'].',';
			echo $result['end_date'].',';
			echo $result['time'].',';
			echo $people[$result['resource']]['name'].',';
			echo $status."\r\n";
		}


	}

	//Don't echo out the table if the user is downloading a csv version
	if(!(isset($_REQUEST['csv']))){
?>
<table
<form action="./list.php" method="get">
	<label><b>Page:</b></label>
	<input type="submit" value="First" name="first">
	<input type="submit" value="Previous" name="previous">
	<input type="submit" value="Next" name="next">
	<input type="submit" value="Last" name="Last"><br />
	<label><b>Download: </b></label>
	<input type="submit" value="Download as csv" name="csv">
</form>
</body>
</html>
<?php
	}
?>
