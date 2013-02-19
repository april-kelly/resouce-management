<?php
//Include the data object
include('data.php');

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
	text-align: left;
}
table{
}
</style>

<h3>By Week:</h3>
  <table border="1">
  
  <tr>
    <td>Resource:</td>
    <td>Week 1:</td>
    <td>Week 2:</td>
    <td>Week 3:</td>
    <td>Week 4:</td>
    <td>Week 5:</td>
    <td>Week 6:</td>
    <td>Week 7:</td>
    <td>Week 8:</td>
   </tr>
   
   <tr>
    <td>Joe Smoe</td>
    <td>40</td>
    <td>42</td>
    <td>38</td>
    <td>10</td>
    <td>50</td>
    <td>43</td>
    <td>40</td>
    <td>47</td>
   </tr>
   
<?php
   }
   	//get the people table
	$result = query('SELECT * FROM people');
	
	//fix the people results to have an index matching that of the database
	$people = array();
	
	foreach($result as $result){
		$people[$result['index']]['index'] = $result['index'];
		$people[$result['index']]['name'] = $result['name'];
		$people[$result['index']]['type'] = $result['type'];
	}                                        

	
	//echo out the results
	foreach($people as $people)
	{
		echo '<tr>';
		echo '<td>'.$people['name'].'<td>';
		
		
		//get the projects
		$project = query("SELECT * FROM test WHERE resource='".$people['index']."'");
		if(!(empty($project))){
			
			$past_week = '';
			$i = '0';
			$sort = $project;
			foreach($project as $project){   
				
				if(!($past_week == $project['week_of'])){
					//spit out hours
					echo '<td>'.$project['time'];
				}
				
				//Add one to the increment operator
				$j = $i + 1;
			
				//See if another record exists
				if(array_key_exists($j, $sort)){
			
				//If another record exists see if it is of the same week as the current record
				if(!($project['week_of'] == $sort[$j]['week_of'])){
					echo '</td>';
				}
				}else{
					echo '</td>';
				}
			
				//Make the past week equal this week before moving to the next record
				$past_week = $project['week_of'];
				$i++;
			}
		//echo '<td>'.var_dump($project).'<td>';
		}                                                 
		
		echo '</tr>';
	}

?>
</table>
</body>
</html>

