<?php
/**
 * Name:        Monthly overview excel output
 * Programmer:  Liam Kelly
 * Date:        7/31/13
 */

//Start the users session
if(!(isset($_SESSION))){
    session_start();
}

//Includes
require_once('../path.php');
require_once(ABSPATH.'includes/view.php');
include_once(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php'); //we include instead to allow us to fail more gracefully

//This allows us to create a spreadsheet based on what the user was viewing
$page_offset = $_SESSION['page_offset'];
$page_count  = $_SESSION['page_count'];

//Setup the views class
$views = new views;
$table = $views->build_table($page_offset, $page_count);
$weeks = $views->weeks;

//Make a copy of the table
$copy = $table;

//rebuild the table for excel or csv
$excel[0]["name"] = 'Resource';
$i = 1;
foreach($weeks as $week){


    $excel[0][$i] = $week;
    $i++;
}

$i = 1;
foreach($copy as $copy_row){

    //Remove the user id
    unset($copy_row["id"]);

    //Replace week key with number key (the week keys make the excel class break)
    $w = 1;
    foreach($weeks as $week){

        if(isset($copy_row[$week])){

            if(preg_match('/h/', $copy_row[$week])){
                $temp = trim($copy_row[$week], '-');
            }else{
                $temp = $copy_row[$week];
            }

            $excel[$i]["name"] = $copy_row["name"];
            $excel[$i][$w] = trim($temp, 'h');
            $w++;

        }
    }

    $i++;
}


//Excel output:
if(file_exists(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php') && isset($_REQUEST['excel'])){

    try{

        $PhpToXls = new ABG_PhpToXls($excel, null, 'month', true);
        $PhpToXls->SendFile();

    }

        catch(Exception $Except){

    }

}elseif(isset($_REQUEST['csv'])){

    header('Content-disposition: attachment; filename=month.csv');
    header('Content-type: application/csv');

    foreach($excel as $excel_row){

       echo implode(',', $excel_row)."\r\n";

    }




}


