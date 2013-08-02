<?php
/**
 * Name:       Shows the system status
 * Programmer: Liam Kelly
 * Date:       7/2/13
 */

//includes
require_once(ABSPATH.'includes/config/settings.php');

//fetch the settings
$set = new settings;
$settings = $set->fetch();

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
    if($_SESSION['admin'] >= 1){

        //User is logged in
        ?>
        <div id="status">
            <p>
                Hello and welcome to version <?php echo $settings['version']; if($setting['production'] == false){ echo ' beta'; }?> of the Bluetent Resource Management software.
            </p>
        </div>
        <?php

    }else{

        //User is not admin
        ?><span class="error">You must be an administrator to access this page.</span><?php

    }

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}

?>