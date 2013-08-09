<?php
/**
 * Name:       resouce-management     
 * Programmer: liam
 * Date:       7/2/13
 */

//includes
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//Fetch values to populate fields
$set = new settings;
$settings = $set->fetch();

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
if($_SESSION['admin'] >= 1){

//User is logged in

?>
<fieldset>

        <legend>General Options:</legend>

        <form action="./admin/save.php" method="post"><br />

            <b>Overview </b><br /><br />

            <input type="hidden" name="month_colors" value="FALSE" />
            <input type="checkbox" name="month_colors" value="TRUE" <?php if($settings['month_colors'] == TRUE){ echo "checked"; } ?> />
            <label>Enable coloration</label><br />
            <input type="hidden" name="month_excel" value="FALSE" />
            <input type="checkbox" name="month_excel" value="TRUE" <?php if($settings['month_excel'] == TRUE){ echo "checked"; } ?> />
            <label>Enable excel output</label><br />
            <input type="hidden" name="month_output" value="FALSE" />
            <input type="checkbox" name="month_output" value="TRUE" <?php if($settings['month_output'] == TRUE){ echo "checked"; } ?> />
            <label>Enable output</label><br />
            <input type="text" name="weeks" value="<?php echo $settings['weeks'] ?>" />
            <label># of weeks to display</label><br /><br />


            <?php

            //class 2 admin only
            if($_SESSION["admin"] >= '2'){

            ?>


            <b>Database</b><br /><br />
            <input type="text" name="db_host" value="<?php echo $settings['db_host']; ?>" /><label>Database Hostname</label><br />
            <input type="text" name="db_user" value="<?php echo $settings['db_user']; ?>" /><label>Database Username</label><br />
            <input type="password" name="db_pass" value="<?php echo $settings['db_pass']; ?>" /><label>Database Password</label><br />
            <input type="text" name="db_database" value="<?php echo $settings['db_database']; ?>" /><label>Database Name</label><br />
            <br />


            <b>Users</b><br /><br />
            <input type="text" name="timeout" value="<?php echo $settings['timeout']; ?>" /<label>Session timeout (in seconds)</label>
            <br />


            <?php
            }
            ?>

<br />
<input type="submit" value="Update" />

</form>

</fieldset>
<?php    }else{

    //User is not admin
    ?><span class="error">You must be an administrator to access this page.</span><?php

}

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}
?>