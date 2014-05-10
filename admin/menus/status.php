<?php
/**
 * Name:       Shows the system status
 * Programmer: Liam Kelly
 * Date:       7/2/13
 */

//includes
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/data.php');

//fetch the settings
$set = new settings;
$settings = $set->fetch();

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
    if($_SESSION['admin'] >= 1){

        //User is logged in
        ?>
            <p>
                Hello and welcome to version <?php echo $settings['version']; if($setting['production'] == false){ echo ' beta'; }?> of the Bluetent Resource Management software.
            </p>

        <?php

        //Check database size
        $dbc = new db;
        $dbc->connect();
        $count = $dbc->query("select count(*) from jobs ");
        $dbc->close();

        if($count[0]["count(*)"] >= 8000000){


            echo '<span class="info">Your jobs table contains '.$count[0]["count(*)"].' rows (of a maximum of 8388607 rows), please run the db cleaning tool.</span>';


        }

    }else{

        //User is not admin
        ?><span class="error">You must be an administrator to access this page.</span><?php

    }

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}

?>