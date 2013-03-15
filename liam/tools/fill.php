<?php
//include the data object
include('../data.php');

$people = query('SELECT * FROM people');
	$hours = serialize(array( 
		"sunday"    	=> '13',
		"monday"   	=> '0',
		"tuesday"   	=> '0',
		"wednesday" 	=> '0',
		"thursday"  	=> '0',
		"friday"    	=> '0',
		"saturday"  	=> '0',
		));
	
$current = '2013-03-10'; //date('Y-m-d');
$show = 1;
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
	
	$result = $dbc->insert("INSERT INTO `resources`.`jobs` (`index`, `project_id`, `manager`, `resource`, `week_of`, `time`, `priority`, `sales_status`) VALUES (NULL, '88989', '29', '".$people['index']."', '".$weeks."', '".$hours."', '1', '1')");
	echo $people['name']."  ".$weeks."\r\n";
	//echo "Week: ".$weeks."\r\n";
	}
	
	$weeks = $copy;
}

	//$result = $dbc->insert($query);	//run the query
	$dbc->close();

?>
