<?php
/**
 * Name:       Resource Management Admin Security Menu
 * Programmer: Liam Kelly
 * Date:       8/15/13
 */

?>

<fieldset>

    <legend>Internal System Security:</legend>

    <form action="./admin/save.php" method="post"><br />

        <input type="hidden" name="logging" value="FALSE" />
        <input type="checkbox" name="logging" value="TRUE" <?php if($settings['logging'] == TRUE){ echo "checked"; } ?> />
        <label>Enable Logging</label><br />

        <input type="hidden" name="IIstep" value="FALSE" />
        <input type="checkbox" name="IIstep" value="TRUE" <?php if($settings['IIstep'] == TRUE){ echo "checked"; } ?> />
        <label>Enable Two Factor Authentication</label><br />

        <input type="hidden" name="strict" value="FALSE" />
        <input type="checkbox" name="strict" value="TRUE" <?php if($settings['strict'] == TRUE){ echo "checked"; } ?> />
        <label>Disable Anonymous Users</label><br />


        <br />
        <input type="submit" value="Update" />

    </form>

</fieldset>

<fieldset>

    <legend>User Security:</legend>

    <form action="./admin/save.php" method="post"><br />


        <input type="text" name="timeout" value="<?php echo $settings['timeout']; ?>" /><label>Session timeout (in seconds)</label>
        <br />

        <input type="submit" value="Update" />

    </form>
</fieldset>

<!--
<fieldset>

    <legend>Security Groups:</legend>

    Not Implemented (yet)

</fieldset>
-->