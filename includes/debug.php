<?php
/**
 * Name:       Options for the global debug mode
 * Programmer: Liam Kelly
 * Date:       6/27/13
 */

//include the data object
require_once('path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->debug;

if($status == true){

    if(isset($_SESSION['debug'])){

        $debug = $_SESSION['debug'];
        unset($_SESSION['debug']);

    }else{

        $debug = '';

    }

    switch($debug){

        CASE "fill":
            $page = 'admin/tools/fill.php';
        break;

        CASE "list":
            $page = 'admin/tools/list.php';
        break;

        DEFAULT:
            //Just show the current page
            $default = true;
        break;

    }

    if(!(empty($page))){
        //show the requested page
        include_once(ABSPATH.$page);
    }
    if($default = true){
        //show the normal page
        ?>
        <h3>Extra admin tools:</h3>
        <a href="./?p=debug&d=fill">fill.php</a> Fills the jobs table with random data. <br />
        <a href="./?p=debug&d=list">list.php</a> Lists the contents of the database. <br />
        <?php
    }


}else{
    echo '<span class="error">To view this page, debug mode most be enabled.</span>';
}