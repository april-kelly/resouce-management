<?php
/*


//Create the $table array and put the resources in it
$table = array();
$i = 0;
foreach($resource as $resource){
	
	$table[$i] = array( 'id' => $resource['index'], 'name' => $resource['name'], 'weeks' => array(1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '') );
	$i++;
}

//Start putting data into the weeks section
$start_week = '2013-02-10';
foreach($table as $table){
	
	//Get all projects applicable by resource and week
	for($i = 1; $i <= 8; $i++){
		
		//Setup dates
		$date = new DateTime($start_week);
		$date->add(new DateInterval('P07D'));
		$week = $date->format('Y-m-d') . "\n";
		$start_week = $week;
		
		//Query the database
		//$project = query("SELECT * FROM test WHERE resource='".$table['id']."' AND week_of='".$week."'");
		//echo "SELECT * FROM test WHERE resource='".$table['id']."' AND week_of='".$week."' \r\n";
		
		$hours = '';
		//count the hours up for each week
		if(!(empty($project))){
		foreach($project as $project){
			
			if(!(empty($project['time']))){
				$hours = $hours + $project['time'];
			}else{
				$hours = '0';
			}
			
		}
		}
		
		//Stuff the hours into the table
		$table[]['week'][$i] = $hours;
		
	}
	
	//reset the start_week variable
	$start_week = '2013-02-10';
}



*/
?>
