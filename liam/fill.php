<?php
//include the data object
include('data.php');

$people = query('SELECT * FROM people');
	$hours = serialize(array( 
		"sunday"    	=> "5",
		"monday"   	=> "5",
		"tuesday"   	=> "5",
		"wednesday" 	=> "5",
		"thursday"  	=> "5",
		"friday"    	=> "5",
		"saturday"  	=> "5",
		));
$current = date('Y-m-d');
$show = 300;
$weeks = array();
$weeks[1] = $current;
for($i = 2; $i <= $show; $i++){
	$weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
//var_dump($weeks);

$copy = $weeks;

	$dbc = new db;			//set up object
	$dbc->connect();		//connect using defaults

	
foreach($people as $people){

	foreach($weeks as $weeks){
	$result = $dbc->insert("INSERT INTO `resources`.`test` (`index`, `project_id`, `manager`, `resource`, `week_of`, `time`, `priority`, `sales_status`) VALUES (NULL, '88989', '29', '".$people['index']."', '".$weeks."', '".$hours."', '1', '1')");
	//echo "Week: ".$weeks."\r\n";
	}
	
	$weeks = $copy;
}

	//$result = $dbc->insert($query);	//run the query
	$dbc->close();

?>
