<?php
/**
 * Name:        Monthly overview excel output
 * Programmer:  Liam Kelly
 * Date:        7/31/13
 */

//Includes
require_once('../path.php');
require_once(ABSPATH.'includes/view.php');
include_once(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php'); //we include instead to allow us to fail more gracefully

$views = new views;
$table = $views->build_table();
$weeks = $views->weeks;

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

            $excel[$i]["name"] = $copy_row["name"];
            $excel[$i][$w] = $copy_row[$week];
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

    $csv = array();

    foreach($excel as $excel){

        $csv = $csv.implode(',', $excel)."\r\n";

    }

    header('Content-disposition: attachment; filename=month.csv');
    header('Content-type: application/csv');

    echo $csv;

}


