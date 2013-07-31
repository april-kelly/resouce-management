<table border="1" class="data">
<?php

//Includes
error_reporting(E_STRICT);
    //Make sure the ABSPATH constant is defined
    if(!(defined('ABSPATH'))){
        require_once('../path.php');
    }

    //Needed to execute
    require_once(ABSPATH.'includes/data.php');
    require_once(ABSPATH . 'includes/config/settings.php');
    require_once(ABSPATH.'includes/view.php');

//Settings
$set = new settings;
$settings = $set->fetch();

//Others
$color_enable = $settings['month_colors'];
$excel_enable = $settings['month_excel'];
$show	      = $settings['weeks'];
$output       = $settings['month_output'];
//$colors       = $settings['colors'];
$i = 0;

//Optionally include the excel output class
if(file_exists(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php')){
    include_once(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php');
}else{
    $excel_enable = FALSE;
}

/*
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
$people = $dbc->query('SELECT * FROM people WHERE `type` != 3');	//Get the table of people
$rd = "SELECT * FROM jobs WHERE week_of BETWEEN '".$weeks[1]."' AND '".$weeks[$count]."' ";
    $test = $dbc->query($rd);
    echo $rd;

    $i++;

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
    $query = "SELECT * FROM jobs WHERE resource='".$people['index']."' AND week_of BETWEEN '".$weeks[1]."' AND '".$weeks[$count]."' ";
    $i++;

    $project = $dbc->query($query);


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

    var_dump($table);
*/
$test = new views;
$table = $test->build_table();


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


    /*//Excel/CSV output:
	$copy = $table;

    //figure out where the end of the table is
    $end = end($copy);
    $date_location = $end['id'] + 2;
    $space_location = $end['id'] + 1;

    //add the "Last updated:" notice to the array
    $copy[$space_location]['name'] = "";
    $copy[$date_location]['name'] = "Last updated: ";
    $copy[$date_location]['1'] = date('g:ia T');


	$i = 1;		//Must be set to the first row after the header
	foreach($copy as $copy){
		$excel[$i] = $copy;
		$i++;
	}

    //Excel output
    if($excel_enable == true){

        try{
            $PhpToXls = new ABG_PhpToXls($excel, null, 'month', true);
            $PhpToXls->SaveFile();
        }
        catch(Exception $Except){

        }

    }else{

        //Fail over to CSV output
        $csv = '';
        foreach($excel as $excel){
            $csv = $csv.implode(',', $excel)."\r\n";
        }
        file_put_contents('month.csv', $csv);

    }*/


//echo out each of the rows in the table
foreach($table as $table){
	
	echo "\t".'<tr>'."\r\n";
	echo "\t\t".'<td><a href="./?p=week&amp;w='.$table['id'].'">'.$table['name'].'</a></td>'."\r\n";
	
	for($i = 1; $i <= $count; $i++){
		echo "\t\t".'<td>';
		
		if($color_enable == true){
			
		   if($table[$i] == 0) { echo '<span class="colors zero" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '15' && $table[$i] >= '1') { echo '<span class="colors low" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '25' && $table[$i] >= '16') { echo '<span class="colors medium" >'.$table[$i].'</span>'; }
		   if($table[$i] <= '40' && $table[$i] >= '26') { echo '<span class="colors high" >'.$table[$i].'</span>'; }
		   if($table[$i] >= '41') { echo '<span class="colors veryhigh" >'.$table[$i].'</span>'; }
		
		}else{
			echo $table[$i];
		}
		echo '</td>'."\r\n";
	}  
	
	echo "\t".'</tr>'."\r\n\r\n";
	
}

}else{
    echo '<span class="error"><b>Error</b>: <em>Database connection failed.</em></span>';
}

	
?>
</table>
<p>
<?php
 echo 'Queried the database '.$i.' times. <br />';
 echo 'Page last updated: '.date('m-d-Y'); //outputs the date in mm-dd-yyyy
 echo ' at '.date('g:ia T'); //outputs the hour:minute am/pm and the timezone
 if($excel_enable = TRUE){
?>
<br />
    You can also <a href="./month.xls">download</a> this in excel format.
</p>
<?php
}else{
?>
<br />
    You can also <a href="./month.csv">download</a> this in csv format.
</p>
<?php
}
 //Easter egg
 if(date('md') == '0225'){
     echo base64_decode('PGJyIC8+PHAgY2xhc3M9ImluZm8iPjxpPiJXaGVuIGdvaW5nIHRocm91Z2ggaGVsbCwganVzdCBr
                         ZWVwIGdvaW5nLiI8L2k+IC1XaW5zdG9uIENodXJjaGlsbDxiciAvPiAxICZhbmQ7IDEgPSAmZW1w
                         dHk7PC9wPg==');
 }

?>
