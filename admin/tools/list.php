<?php
//Include the data object
require_once('path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->fetch();

if($status['debug'] == true && $_SESSION['admin'] >= '2'){

//Force csv download (if applicable)
   $file = "resources.csv";
   if(isset($_REQUEST['csv'])){
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: text/csv"); 
    header("Content-disposition: attachment; filename=\"".$file."\"");
   }else{
?>


<table border="1">
<tr>
	<td>
	  <a href="?c=1&o=1"><img src="./includes/images/up.png" title="Order by Index ascending" /></a>
	  <b>index:</b>
	  <a href="?c=1&o=2"><img src="./includes/images/down.png" title="Order by Index descending" /></a>
	</td>
	
	<td>
	  <a href="?c=2&o=1"><img src="./includes/images/up.png" title="Order by Project ID ascending" /></a>
	  <b>project_id:</b>
	  <a href="?c=2&o=2"><img src="./includes/images/down.png" title="Order by Project ID descending" /></a>
	</td>
	
	<td>
	  <a href="?c=3&o=1"><img src="./includes/images/up.png" title="Order by Manager ascending" /></a>
	  <b>manager:</b>
	  <a href="?c=3&o=2"><img src="./includes/images/down.png" title="Order by Manager descending" /></a>
	</td>
	
	<td>
	  <a href="?c=7&o=1"><img src="./includes/images/up.png" title="Order by Resource ascending" /></a>
	  <b>resource:</b>
	  <a href="?c=7&o=2"><img src="./includes/images/down.png" title="Order by Resource descending" /></a>
	</td>
	
	
	<td>
	  <a href="?c=4&o=1"><img src="./includes/images/up.png" title="Order by Start Date ascending" /></a>
	  <b>week_of:</b>
	  <a href="?c=4&o=2"><img src="./includes/images/down.png" title="Order by Start Date descending" /></a>
	</td>
	
	<!--<td>
	  <a href="?c=5&o=1"><img src="../images/up.png" title="Order by End Date ascending" /></a>
	  <b>time:</b>
	  <a href="?c=5&o=2"><img src="../images/down.png" title="Order by End Date descending" /></a>
	</td>-->
	
			 <td>Sunday</td>
		 <td>Monday</td>
		 <td>Tuesday</td>
		 <td>Wednesday</td>
		 <td>Thursday</td>
		 <td>Friday</td>
		 <td>Saturday</td>
	
	<td>
	  <a href="?c=6&o=1"><img src="./includes/images/up.png" title="Order by Time ascending" /></a>
	  <b>priority:</b>
	  <a href="?c=6&o=2"><img src="./includes/images/down.png" title="Order by Time descending" /></a>
	</td>
	
	<td>
	  <a href="?c=8&o=1"><img src="./includes/images/up.png" title="Order by Sales Status ascending" /></a>
	  <b>sales_status:</b>
	  <a href="?c=8&o=2"><img src="./includes/images/down.png" title="Order by Sales Status descending" /></a>
	</td>
	
</tr>
<?php
   }
   	//preset variables
   	$column = '';
   	$order = '';
   	
   		
	//the base query
	$query = 'SELECT * FROM `jobs` ';
   	
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
	
	//Query for a delete
	if(isset($_REQUEST['rm'])){
		
		//Delete query
		$delete = 'DELETE FROM `jobs` WHERE `index`='.$_REQUEST['rm'];
		
		//Run the query
		$dbc = new db;
		$dbc->connect();
		$project = $dbc->delete($delete);
		$dbc->close();
		
		//redirect to the normal view
		header('Location: ?edit');
		
	}
	
	//csv header
	$csv = "Index:,Project_id:,Manager:,Start_Date:,End_Date:,Time:,Resource:,Sales Status:\r\n";
	
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
			
			//echo out resource
			if($resource == true){
				echo '<td>',$people[$project['resource']]['name'],'</td>';
			}else{
				echo '<td><span style="color: red;">[Error]</span></td>';
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
		
			$time = unserialize($project['time']);
			echo '<td>',$project['week_of'],'</td>';
			echo '<td>',$time['sunday'],'</td>';
			echo '<td>',$time['monday'],'</td>';
			echo '<td>',$time['tuesday'],'</td>';
			echo '<td>',$time['wednesday'],'</td>';
			echo '<td>',$time['thursday'],'</td>';
			echo '<td>',$time['friday'],'</td>';
			echo '<td>',$time['saturday'],'</td>';
			echo '<td>',$priority,'</td>';
			echo '<td>',$status,'</td>';
			
			//show delete options if editing is enabled
			if(isset($_REQUEST['edit'])){
				echo '<td><a href="?rm='.$project['index'].'"><img src="../images/x.jpg" height="23" width="32" title="Delete this request"></a></td>';
			}
			
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

?>
    </table>
<?php
}else{
    ?><span class="error">You do not enough have permission to view this page or debug mode is not enabled.</span><?php
}
?>
