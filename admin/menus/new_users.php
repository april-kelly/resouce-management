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

//User is logged ind
?>
<fieldset>

    <legend>Edit a User:</legend>

    <form action="./admin/menus/user_save.php" method="post" class="button">

        <input type="hidden" name="p" value="admin" />
        <input type="hidden" name="a" value="users" />
        <br /><b>Select a user:</b><br /><br />
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

                echo '                ';
                echo '<option value="',$person['index'],'" '.$selected.' >',$person['firstname'],' ',$person['lastname'],'</option>'."\r\n";

            }
            ?>

        </select>
        <input type="submit" value="Select" name="select"/>

        <?php
        if(isset($_SESSION['user_lookup'])){
            $users = new users;
            $request = $users->select($_SESSION['user_lookup']);

            if(!($request == false)){

                ?>
               <br /> <br />Profile Picture <br /><a href="./?p=edit_pic">
                <img src="<?php
                if(!(empty($request[0]["profile_pic"]))){
                    echo './includes/images/uploads/'.$request[0]["profile_pic"];
                }else{
                    echo './includes/images/default.jpg';
                }
                ?>" alt="Click to edit" title="Click to edit" class="profile_pic"/></a><br /><br />
                <input type="hidden" name="userid" value="<?php echo $request[0]['index']; ?>" />
                <input type="text" name="firstname" value="<?php echo $request[0]['firstname']; ?>" /><label>First</label><br /><br />
                <input type="text" name="lastname" value="<?php echo $request[0]['lastname']; ?>" /><label>Last</label><br /><br />
                <input type="text" name="email" value="<?php echo $request[0]['email']; ?>" /><label>Email</label><br /><br />
                <input type="text" name="phone_number" value="<?php echo $request[0]['phone_number']; ?>" autocomplete="off"/><label>Phone Number</label><br /><br />
                <select name="type">
                    <option value="2" <?php if($request[0]['admin'] =='2'){ echo ' selected '; }?> >Project Resource</option>
                    <option value="1" <?php if($request[0]['admin'] =='1'){ echo ' selected '; }?>>Project Manager</option>
                    <option value="0" <?php if($request[0]['admin'] =='0'){ echo ' selected '; }?>>Both</option>
                </select>
                <label>Type of resource</label>
                <br /><br />
                <?php

                if(!($_SESSION['userid'] == $_SESSION['user_lookup']) && !($_SESSION['admin'] < $request[0]['admin'])){

                    ?>
                    <select name="admin">

                        <?php

                            if($_SESSION['admin'] >= '0'){

                                echo '<option value="0"';

                                if($request[0]['admin'] =='0'){
                                    echo ' selected ';
                                }

                                echo '>Normal</option>';

                            }

                            if($_SESSION['admin'] >= '1'){

                                echo '<option value="1"';

                                    if($request[0]['admin'] =='1'){
                                        echo ' selected ';
                                    }

                                    echo '>Administrator</option>';

                             }

                            if($_SESSION['admin'] >= '2'){

                                echo '<option value="2"';

                                    if($request[0]['admin'] =='2'){
                                        echo ' selected ';
                                    }

                                    echo '>Debugger</option>';

                            }

                            if($_SESSION['admin'] >= '3'){

                                echo '<option value="3"';

                                    if($request[0]['admin'] =='3'){
                                        echo ' selected ';
                                    }

                                    echo '>Developer</option>';

                            }


                        ?>
                    </select>
                    <label>Type of user</label><br />
                <?php

                }else{

                        echo '<span class="info">You cannot edit this person\'s admin class.</span><br />';

                }

                ?>
                <br /><input type="submit" value="Update" name="update"/><input type="submit" value="Reset" name="reset"/><input type="submit" value="Delete" name="delete"/>

                <br />
                <?php

                    if(isset($_SESSION['reset_code'])){

                        echo '<span class="success">The reset code is: '.$_SESSION['reset_code'].'';
                        echo '<br /> The link is: <a href="'.$settings['url'].'?p=reset_code&c='.$_SESSION['reset_code'].'">'.$settings['url'].'?p=reset_code&c='.$_SESSION['reset_code'].'</a></span>';
                        unset($_SESSION['reset_code']);

                    }

              }

        }
        ?>



    </form>

</fieldset>

<h3>Or,</h3>

<fieldset>

    <legend>Add a User:</legend>

    <form action="./admin/menus/user_save.php" method="post" class="button">

        <br /><b>Add a user:</b><br /><br />

        <input type="text" name="firstname" value="" autocomplete="off" /><label>First</label><br /><br />
        <input type="text" name="lastname" value="" autocomplete="off" /><label>Last</label><br /><br />
        <input type="text" name="email" autocomplete="off" /><label>Email</label><br /><br />
        <input type="text" name="phone_number" autocomplete="off"/><label>Phone Number</label><br /><br />
        <input type="password" name="password" autocomplete="off"/><label>Password</label><br /><br />
        <select name="type">
            <option value="2">Project Resource</option>
            <option value="1">Project Manager</option>
            <option value="0">Both</option>
        </select>
        <label>Type of resource</label>
        <br /><br />
        <select name="admin">
            <?php

            if($_SESSION['admin'] >= '0'){

                echo '<option value="0"';

                if($request[0]['admin'] =='0'){
                    echo ' selected ';
                }

                echo '>Normal</option>';

            }

            if($_SESSION['admin'] >= '1'){

                echo '<option value="1"';

                if($request[0]['admin'] =='1'){
                    echo ' selected ';
                }

                echo '>Administrator</option>';

            }

            if($_SESSION['admin'] >= '2'){

                echo '<option value="2"';

                if($request[0]['admin'] =='2'){
                    echo ' selected ';
                }

                echo '>Debugger</option>';

            }

            if($_SESSION['admin'] >= '3'){

                echo '<option value="3"';

                if($request[0]['admin'] =='3'){
                    echo ' selected ';
                }

                echo '>Developer</option>';

            }


            ?>
        </select>
        <label>Type of user</label><br /><br />

        <input type="submit" value="Add" name="add" />

        <br />
        <?php

        if(isset($_SESSION['success'])){

            echo '<span class="success">Added user.</span>';
            unset($_SESSION['success']);

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