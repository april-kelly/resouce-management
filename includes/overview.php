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

$view = new views;
$table = $view->build_table();

//Echo out the table

    //Define indents
    $indentI    = '   ';    //Indent the outputted source 5 spaces
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
                echo $indentII.'<td>'.$table_row[$week].'</td>'."\r\n";
            }

        echo $indentI.'</tr>'."\r\n";

    }

    echo '</table>';