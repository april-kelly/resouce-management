<table border="1" class="data">
<?php
//Includes

    //needed to execute
    require_once(ABSPATH.'/data.php');
    require_once(ABSPATH . '/config/settings.php');

    //optional
    include_once(ABSPATH.'/excel/ABG_PhpToXls.cls.php');

//Settings
$set = new settings;
$settings = $set->fetch();



//Others
$color_enable = $settings['month_colors'];
$excel_enable = $settings['month_excel'];
$show	      = $settings['weeks'];
$output       = $settings['month_output'];
//$colors       = $settings['colors'];

//Define variables
$hours = '';

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

//Connect to the database
$dbc = new db;
$connection = $dbc->connect();


//Prevent anything from running if the connection failed
if(is_bool($connection)){
    if($connection = FALSE){
        $fail = TRUE;
    }else{
        $fail = FALSE;
    }
}

if($fail = TRUE){
//Fetch the list of resources
$people = $dbc->query('SELECT * FROM people');	//Get the table of people

//create the table
$i = 0;

//Start building the table
foreach($people as $people)
{
	//Build the table
	$table[$people['index']]['id'] = $people['index'];
	$table[$people['index']]['name'] = $people['name'];
	
	for($i = $count; $i >= 1; $i--){
		
		$table[$people['index']][$i] = '0';
		
	}
	
	//Get the list of projects for each person
	$project = $dbc->query("SELECT * FROM jobs WHERE resource='".$people['index']."' ");


	//Make sure the person actually has projects
	if(!(empty($project))){
			
		foreach($project as $project){
			
			for($i = $count; $i >= 1; $i--){
				
				if($project['week_of'] == $weeks[$i]){
					
					//Process the hours
					
					//unserialize the hours array
					$time = unserialize($project['time']);
					
					//add everything up
                    $hours = $hours + $time['sunday']
							+ $time['monday']
							+ $time['tuesday']
							+ $time['wednesday']
							+ $time['thursday']
							+ $time['friday']
							+ $time['saturday'];
								
					//insert the hours into the table
					$table[$people['index']][$i] = $table[$people['index']][$i] + $hours; 
						
					//empty the hours variable
					$hours = '';
					
				}					
					
			}
				
		}
		
		
	}
	
}
//close the database connection
$dbc->close();

if($output == true){
//Echo out the table header
echo "\t".'<tr class="header">'."\r\n\r\n";
echo "\t\t".'<td>Resource: </td>'."\r\n";
$excel[0][0] = "Resource:";
$i = 1;
foreach($weeks as $weeks){
	echo "\t\t".'<td>'.$weeks.'</td>'."\r\n";
	$excel[0][$i] = $weeks;
	$i++;
}
echo "\t".'</tr>'."\r\n\r\n";



//Excel output:
if($excel_enable == true){
	
	$copy = $table;

	$i = 1;		//Must be set to the first row after the header
	foreach($copy as $copy){
		$excel[$i] = $copy;
		$i++;
	}

	try{
		$PhpToXls = new ABG_PhpToXls($excel, null, 'month', true);
		$PhpToXls->SaveFile();
	}
	catch(Exception $Except){ 
	
	}
	
}


  
  
//echo out each of the rows in the table
foreach($table as $table){
	
	echo "\t".'<tr>'."\r\n";
	echo "\t\t".'<td><a href="./?p=week&w='.$table['id'].'">'.$table['name'].'</a></td>'."\r\n";
	
	for($i = 1; $i <= $count; $i++){
		echo "\t\t".'<td>';
		
		if($color_enable == true){
			
		   if($table[$i] == 0) { echo '<span id="colors" class="zero" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '15' && $table[$i] >= '1') { echo '<span id="colors" class="low" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '25' && $table[$i] >= '16') { echo '<span id="colors" class="medium" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '40' && $table[$i] >= '26') { echo '<span id="colors" class="high" >'.$table[$i].'</span>'; }
		   if($table[$i] >= '41') { echo '<span id="colors" class="veryhigh" >'.$table[$i].'</span>'; }
		
		}else{
			echo $table[$i];
		}
		echo '</td>'."\r\n";
	}  
	
	echo "\t".'</tr>'."\r\n\r\n";
	
}
}
}else{
    echo '<span class="error"><b>Error</b>: <em>Database connection failed.</em></span>';
}

	
?>
</table>
<?php
 echo 'Last updated: '.date('m-d-Y'); //outputs the date in mm-dd-yyyy
 echo ' at '.date('g:ia T'); //outputs the hour:minute am/pm and the timezone
?>