<?php
//include the data object
require_once('path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/view.php');

//fetch the debug status
$set = new settings;
$status = $set->fetch();

if($status['debug'] == true && $_SESSION['admin'] >= '2'){


$dbc = new db;			//set up object
$dbc->connect();		//connect using defaults

$people = $dbc->query('SELECT * FROM people WHERE `type` != 3');

$current = date('Y-m-d');
$show = 12;

$views = new views;
$weeks = $views->weeks;

$weeks[1] = $current;
for($key = 2; $key <= $show; $key++){
	$weeks[$key] = $current = date('Y-m-d',strtotime($current) + (24*3600*7));
}
//var_dump($weeks);

$copy = $weeks;

	
foreach($people as $person){

	foreach($weeks as $week){
            
            	$hours =  rand('0', '40').':00:00';

	
	$result = $dbc->insert("INSERT INTO `resources`.`jobs` (`index`, `project_id`, `manager`, `resource`, `requestor`, `week_of`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sales_status`, `priority`) VALUES (NULL, '123', '1', '".$person['index']."', '1', '".$week."', '".$hours."', '', '', '', '', '', '', '1', '2');");
	echo $people['name']."   ".$week."<br />\r\n";
	//echo "Week: ".$weeks."\r\n";
	}
	
	$weeks = $copy;
}

	//$result = $dbc->insert($query);	//run the query
	$dbc->close();

}else{
    ?><span class="error">You do not enough have permission to view this page or debug mode is not enabled.</span><?php
}
?>
