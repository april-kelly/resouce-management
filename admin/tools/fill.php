<?php
//include the data object
require_once('path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->debug;

if($status == true){


$dbc = new db;			//set up object
$dbc->connect();		//connect using defaults

$people = $dbc->query('SSELECT * FROM people WHERE `type` != 3');

$current = '2013-06-23'; //date('Y-m-d');
$show = 12;
$weeks = array();
$weeks[1] = $current;
for($i = 2; $i <= $show; $i++){
	$weeks[$i] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
//var_dump($weeks);

$copy = $weeks;

	
foreach($people as $people){

	foreach($weeks as $weeks){
            
            	$hours = serialize(array( 
		"sunday"    	=> '0',
		"monday"   	=> rand('0', '40'),
		"tuesday"   	=> '0',
		"wednesday" 	=> '0',
		"thursday"  	=> '0',
		"friday"    	=> '0',
		"saturday"  	=> '0',
		));
	
	
	$result = $dbc->insert("INSERT INTO `resources`.`jobs` (`index`, `project_id`, `manager`, `resource`, `week_of`, `time`, `priority`, `sales_status`) VALUES (NULL, '88989', '28', '".$people['index']."', '".$weeks."', '".$hours."', '1', '1')");
	echo $people['name']."   ".$weeks."<br />\r\n";
	//echo "Week: ".$weeks."\r\n";
	}
	
	$weeks = $copy;
}

	//$result = $dbc->insert($query);	//run the query
	$dbc->close();

}else{
    echo '<span class="error">To use this tool, debug mode most be enabled.</span>';
}
?>
