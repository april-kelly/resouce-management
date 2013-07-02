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

?>
<fieldset>

    <legend>Display Options:</legend>

    <form action="./admin/save.php" method="post"><br />

        <b>insert.php</b><br /><br />

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