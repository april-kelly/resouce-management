<?php
/**
 * Name:       Internal settings menu
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
    if($_SESSION['admin'] >= 2){

        //User is logged in
?>
<fieldset>

    <legend>Insert Options:</legend>

    <form action="./admin/save.php" method="post"><br />

        <b>Insert.php</b><br /><br />

        <input type="hidden" name="insert_valid" value="FALSE" />
        <input type="checkbox" name="insert_valid" value="TRUE" <?php if($settings['insert_valid'] == TRUE){ echo "checked"; } ?> />
        <label>Enable user data validation</label><br />
        <input type="hidden" name="insert_sanitize" value="FALSE" />
        <input type="checkbox" name="insert_sanitize" value="TRUE" <?php if($settings['insert_sanitize'] == TRUE){ echo "checked"; } ?> />
        <label>Enable user data sanitation</label><br />
        <input type="hidden" name="insert_fail" value="FALSE" />
        <input type="checkbox" name="insert_fail" value="TRUE" <?php if($settings['insert_fail'] == TRUE){ echo "checked"; } ?> />
        <label>Force insert to fail</label><br />


        <br />
        <input type="submit" value="Update" />

    </form>

</fieldset>

<fieldset>

    <legend>Settings Options:</legend>

    <form action="./admin/save.php" method="post">
        <b>Core Settings File:</b><br />
        <input type="submit" value="Rebuild" name="rebuild" /><label>Rebuild the settings file from preset defaults</label><br />
        <input type="submit" value="Dump" name="dump" /><label>Dump the contents of the settings file</label><br />
        <input type="submit" value="Download" name="download" /><label>Download the settings file</label><br /><br />
        <b>Core Settings:</b><br />
        <?php if($settings['production'] == FALSE){ ?>
        <input type="hidden" name="production_alert" value="FALSE" />
        <input type="checkbox" name="production_alert" value="TRUE" <?php if($settings['production_alert'] == TRUE){ echo "checked"; } ?> />
        <label>Developmental version alert</label><br />
        <?php } ?>
        <input type="hidden" name="maintenance" value="FALSE" />
        <input type="checkbox" name="maintenance" value="TRUE" <?php if($settings['maintenance'] == TRUE){ echo "checked"; } ?> />
        <label>Maintenance mode</label><br />

        <br /><input type="submit" value="Update" />
    </form>

</fieldset>

<fieldset>

    <legend>Gopher: (experimental)</legend>

    <?php
        //Make sure that php is running on linux
        if(php_uname('s') == 'Linux'){

            //See if the gopher server is online
            echo '<b>Gopher server: </b>';
            if($settings['gopher'] == TRUE){
                echo '<span class="success">Online</span><br /><br />To stop the gopher server run: <pre>telnet localhost 70</pre> and the type: <pre>stop</pre>';
            }else{
                echo '<span class="error">Offline</span><br /><br />To start the gopher server run: <pre>sudo screen php ./gopher_server.php</pre>';
            }

        }else{

            //Let the user know that this feature is not available
            echo "<span class='info'>Were sorry this feature is not available on your platform!</span>";

        }

    ?>

</fieldset>

<fieldset>

    <legend>Debugging Mode:</legend>

    <br />
    <?php
    if($settings['debug'] == FALSE){
        echo 'Click <a href="./admin/save.php?d=1">here</a> to enable debug mode.';
    }else{
        echo 'Click <a href="./admin/save.php?d=0">here</a> to disable debug mode.';
    }
    ?>
    <br /><br />

</fieldset>

        <fieldset>

            <legend>Security:</legend>

            <form action="./admin/save.php" method="post">
                    <b>Salt:</b><br />
                    <input type="submit" value="Change salt" name="salt" /><br /><br />
                    <span class="info"><em>WARNING: Changing this field will invalidate all passwords in the database.</em></span>
            </form>

        </fieldset>

<?php

    }else{

    //User is not admin or not a high enough admin
    ?><span class="error">You must be a class 2 administrator to access this page.</span><?php

}

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}