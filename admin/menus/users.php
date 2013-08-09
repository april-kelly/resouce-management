<?php
/**
 * Name:       User account control and save
 * Programmer: liam
 * Date:       7/2/13
 */
if(!(isset($_SESSION))){
    session_start();
}
//includes
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//Fetch values to populate fields
$set = new settings;
$settings = $set->fetch();

//Fetch the list of users
$dbc = new db;
$dbc->connect();
$people = $dbc->query("SELECT * FROM people");
if(isset($_REQUEST['ajax'])){
    echo $_REQUEST['ajax'];
}


//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
    if($_SESSION['admin'] >= 1){

        //User is logged in
?>
<script>

</script>
<fieldset>

        <legend>Update a user</legend>

        <form action="./" method="get">

            <input type="hidden" name="p" value="admin" />
            <input type="hidden" name="a" value="users"
            <b>Select a user:</b><br />
            <select name='u'>

                <option value="">Select One:</option>

                <?php

                foreach($people as $person){


                    if(isset($_SESSION['user_lookup'])){
                        if($_SESSION['user_lookup'] == $person['index']){
                            $selected = 'selected';
                        }else{
                            $selected = '';
                        }
                    }else{
                        $selected = '';
                    }


                    echo '<option value="',$person['index'],'" '.$selected.' >',$person['firstname'],' ',$person['lastname'],'</option>';

                }
                ?>

            </select>

            <input type="submit" value="Select" />

        </form>

    <?php
    if(isset($_SESSION['user_lookup'])){
        $users = new users;
        $request = $users->select($_SESSION['user_lookup']);
        //unset($_SESSION['user_lookup']);
    ?>

    <form action="./admin/menus/user_save.php" method="post">
        Profile Picture <a href="./?p=edit_pic">(edit)</a><br />
        <img src="<?php
        if(!(empty($request[0]["profile_pic"]))){
            echo './includes/images/uploads/'.$request[0]["profile_pic"];
        }else{
            echo './includes/images/default.jpg';
        }
        ?>" alt="User Profile Image" title="User Profile Image" class="profile_pic"/><br />
            <input type="hidden" name="userid" value="<?php echo $request[0]['index']; ?>" autocomplete="off" />
            <input type="text" name="firstname" value="<?php echo $request[0]['firstname']; ?>" autocomplete="off"/><label>First</label><br />
            <input type="text" name="lastname" value="<?php echo $request[0]['lastname']; ?>" autocomplete="off"/><label>Last</label><br />
            <input type="text" name="email" value="<?php echo $request[0]['email']; ?>" autocomplete="off"/><label>Email</label><br />
            <select name="type" value="<?php echo $request[0]['type']; ?>">
                <option value="2" <?php if($request[0]['admin'] =='2'){ echo ' selected '; }?> >Project Resource</option>
                <option value="1" <?php if($request[0]['admin'] =='1'){ echo ' selected '; }?>>Project Manager</option>
                <option value="0" <?php if($request[0]['admin'] =='0'){ echo ' selected '; }?>>Both</option>
            </select>
            <label>Type of resource</label>
            <br />
            <select name="admin" value="">
                <option value="0" <?php if($request[0]['admin'] =='0'){ echo ' selected '; }?> >Normal</option>
                <option value="1" <?php if($request[0]['admin'] =='1'){ echo ' selected '; }?> >Administrator</option>
                <option value="2" <?php if($request[0]['admin'] =='2'){ echo ' selected '; }?> >Debugger</option>
                <option value="3" <?php if($request[0]['admin'] =='3'){ echo ' selected '; }?> >Developer</option>
            </select>
            <label>Type of user</label><br />

            <input type="submit" value="Update" name="update"/>

    </form>

    <?php
    }
    ?>
</fieldset>

<fieldset>

    <legend>Add a user</legend>

    <form action="./admin/menus/user_save.php" method="post">

        <b>Add a user:</b><br />

        <input type="text" name="firstname" value="" autocomplete="off" /><label>First</label><br />
        <input type="text" name="lastname" value="" autocomplete="off" /><label>Last</label><br />
        <input type="text" name="email" autocomplete="off" /><label>Email</label><br />
        <input type="password" name="password" autocomplete="off"/><label>Password</label><br />
        <select name="type" autocomplete="off">
            <option value="2">Project Resource</option>
            <option value="1">Project Manager</option>
            <option value="0">Both</option>
        </select>
        <label>Type of resource</label>
        <br />
        <select name="admin" autocomplete="off">
            <option value="0">Normal</option>
            <option value="1">Administrator</option>
            <option value="2">Debugger</option>
            <option value="3">Developer</option>
        </select>
        <label>Type of user</label><br />

        <input type="submit" value="Add" name="add" />

    </form>



</fieldset>

<fieldset>

    <legend>Delete a user</legend>

    <form action="./admin/menus/user_save.php" method="post">

        <b>Select a user:</b><br />
        <select name="index">

            <option value="">Select One:</option>

            <?php

            foreach($people as $person){

                echo '<option value="',$person['index'],'">',$person['firstname'],' ',$person['lastname'],'</option>';

            }
            ?>

        </select>

        <input type="submit" value="Delete" name="delete"/><br /><br />

    </form>

</fieldset>

        <fieldset>

            <legend>Reset a user</legend>

            <form action="./admin/menus/user_save.php" method="post">

                <b>Select a user:</b><br />
                <select name="userid">

                    <option value="">Select One:</option>

                    <?php

                    foreach($people as $person){

                        echo '<option value="',$person['index'],'">',$person['firstname'],' ',$person['lastname'],'</option>';

                    }
                    ?>

                </select>

                <input type="submit" value="Reset" name="reset"/><br /><br />

                <?php
                if(isset($_SESSION['reset_code'])){
                    echo '<span class="success">The reset code is: '.$_SESSION['reset_code'].'';
                    echo '<br /> The link is: <a href="'.$settings['url'].'?p=reset_code&c='.$_SESSION['reset_code'].'">'.$settings['url'].'?p=reset_code&c='.$_SESSION['reset_code'].'</a></span>';
                    unset($_SESSION['reset_code']);
                }
                ?>

            </form>

        </fieldset>
<?php
}else{

    //User is not admin
    ?><span class="error">You must be an administrator to access this page.</span><?php

}

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}
