<?php
/**
 * Name:       Display's an overview of the current resource utilization
 * Programmer: liam
 * Date:       7/24/13
 */

//Make sure the ABSPATH constant is defined
if(!(defined('ABSPATH'))){
    require_once('../path.php');
}

//Needed to execute
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/view.php');

//Settings
$set = new settings;
$settings = $set->fetch();

//Others
$color_enable = $settings['month_colors'];
$excel_enable = $settings['month_excel'];
$show	      = $settings['weeks'];
$output       = $settings['month_output'];

//Optionally include the excel output class
if(file_exists(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php')){
    include_once(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php');
}else{
    $excel_enable = FALSE;
}

//Fetch the table
$view = new views;
$table = $view->build_table();
$weeks = $view->weeks;


//Echo out the table

    //Define indents
    $indentI    = '   ';    //Indent the outputted source 5  spaces
    $indentII   = '      '; //Indent the outputted source 10 spaces

   //Echo out the Header
    echo '<table border="1" class="data">';
    echo $indentI.'<tr class="header">'."\r\n";

        echo $indentII.'<td>Resource: </td>'."\r\n";

        foreach($view->weeks as $week){
            echo $indentII.'<td>'.$week.'</td>'."\r\n";
        }

    echo $indentI.'</tr>'."\r\n";

    //Echo out the body of the table
    foreach($table as $table_row){

        echo $indentI.'<tr>'."\r\n";

            echo $indentII.'<td><a href="./?p=week&amp;w='.$table_row["id"].'"> '.$table_row["name"].'</a></td>'."\r\n";

            foreach($view->weeks as $week){

                echo $indentII.'<td>';
                if($color_enable == true){

                    if($table_row[$week] == 0) { echo '<span class="colors zero" >'.$table_row[$week].'</span>'; }
                    if($table_row[$week] <= '15' && $table_row[$week] >= '1') { echo '<span class="colors low" >'.$table_row[$week].'</span>'; }
                    if($table_row[$week] <= '25' && $table_row[$week] >= '16') { echo '<span class="colors medium" >'.$table_row[$week].'</span>'; }
                    if($table_row[$week] <= '40' && $table_row[$week] >= '26') { echo '<span class="colors high" >'.$table_row[$week].'</span>'; }
                    if($table_row[$week] >= '41') { echo '<span class="colors veryhigh" >'.$table_row[$week].'</span>'; }

                }else{
                    echo $table_row[$week];
                }
                echo '</td>'."\r\n";

            }

        echo $indentI.'</tr>'."\r\n";

    }

    echo '</table>';


//output for gopher

ob_start();
echo '+-------------------------------------------+'."\r\n";
echo '|   Bluetent Resource Tracking Overview:    |'."\r\n";
echo '+-------------------------------------------+'."\r\n"."\r\n";
echo '+----------+----------+----------+----------+'."\r\n";

$max_weeks = 4;
$i = 0;
    foreach($weeks as $week){
        echo '|'.$week.'';
        $i++;
        if($max_weeks == $i){
            break;
        }
    }
    echo '|'."\r\n";

foreach($table as $table_row){
    $max_weeks = 4;
    $i = 0;
    echo '+----------+----------+----------+----------+'."\r\n";
    foreach($weeks as $week){
        echo '|     ';
        echo $table_row[$week];
        $count = 5;
        $test = strlen($table_row[$week]);
        $count = $count-$test;
        while($count > 0){
            echo ' ';
            $count--;
        }
        $i++;
        if($max_weeks == $i){
            break;
        }
        //echo '    ';
    }
    echo "|".$table_row["name"]."\r\n";

}
echo '+----------+----------+----------+----------+'."\r\n"."\r\n";
echo '+-------------------------------------------+'."\r\n";
echo '|  Last updated: '.date('m-d-Y').' at '.date('g:ia T').'  |'."\r\n";
echo '+-------------------------------------------+'."\r\n"."\r\n";
$gopher = ob_get_contents();
ob_end_clean();
file_put_contents('../gophermap', $gopher);


    //Echo out the bottom of the page
    echo 'Page last updated: '.date('m-d-Y'); //outputs the date in mm-dd-yyyy
    echo ' at '.date('g:ia T'); //outputs the hour:minute am/pm and the timezone
    if($excel_enable = TRUE){
        ?>
       <br />
       You can also <a href="./includes/excel.php?excel">download</a> this in excel format.
    <?php
    }else{
       ?>
      <br />
      You can also <a href="./month.csv">download</a> this in csv format.

    <?php
    }
    //Easter egg
    if(date('md') == '0225'){
        echo base64_decode('PGJyIC8+PHAgY2xhc3M9ImluZm8iPjxpPiJXaGVuIGdvaW5nIHRocm91Z2ggaGVsbCwganVzdCBr
                            ZWVwIGdvaW5nLiI8L2k+IC1XaW5zdG9uIENodXJjaGlsbDxiciAvPiAxICZhbmQ7IDEgPSAmZW1w
                            dHk7PC9wPg==');
    }
    ?>
    </p>