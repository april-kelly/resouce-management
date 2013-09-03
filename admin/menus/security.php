<?php
/**
 * Name:       Resource Management Admin Security Menu
 * Programmer: Liam Kelly
 * Date:       8/15/13
 */

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
    if($_SESSION['admin'] >= 2){

        //User is logged in

?>


<fieldset>

    <legend>Internal System Security:</legend>

    <form action="./admin/save.php" method="post" class="button"><br />

        <input type="hidden" name="logging" value="FALSE" />
        <input type="checkbox" name="logging" value="TRUE" <?php if($settings['logging'] == TRUE){ echo "checked"; } ?> />
        <label>Enable Logging</label><br />

        <input type="hidden" name="IIstep" value="FALSE" />
        <input type="checkbox" name="IIstep" value="TRUE" <?php if($settings['IIstep'] == TRUE){ echo "checked"; } ?> />
        <label>Enable Two Factor Authentication*</label><br />

        <input type="hidden" name="strict" value="FALSE" />
        <input type="checkbox" name="strict" value="TRUE" <?php if($settings['strict'] == TRUE){ echo "checked"; } ?> />
        <label>Prevent Anonymous Users</label><br />


        <br />
        <input type="submit" value="Update" />
        <br />
        <br />

        <span class="info">* Please not that this only applies to users who have defined phone numbers in the database. </span>

    </form>

</fieldset>

<fieldset>

    <legend>User Security:</legend>

    <form action="./admin/save.php" method="post" class="button"><br />


        <input type="text" name="timeout" value="<?php echo $settings['timeout']; ?>" /><label>Session timeout (in seconds)</label><br />

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

<?php
}else{

    //User is not admin or not a high enough admin
    ?><span class="error">You must be a class 2 administrator to access this page.</span><?php

}

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}