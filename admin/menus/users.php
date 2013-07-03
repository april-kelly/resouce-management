<?php
/**
 * Name:       User account control and save
 * Programmer: liam
 * Date:       7/2/13
 */

///includes
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
?>
<script>

</script>
<fieldset>

        <legend>Update a user</legend>



            <b>Select a user:</b><br />
            <select id="select">

                <option value="">Select One:</option>

                <?php

                foreach($people as $person){

                    echo '<option value="',$person['index'],'">',$person['name'],'</option>';

                }
                ?>

            </select>
            <button onclick="document.location = './admin/menus/users.php?u='.document.write(document.getElementById('select').value)">Select</button><br /><br />

    <div id="form">

    </div>

    <form action="./admin/menus/user.php" method="post">
            <input type="text" name="name"/><label>Name</label><br />
            <input type="text" name="email"/><label>Email</label><br />
            <input type="text" name="password"/><label>Password</label><br />
            <select name="type">
                <option value="2">Project Resource</option>
                <option value="1">Project Manager</option>
                <option value="0">Both</option>
            </select>
            <label>Type of resource</label>
            <br />
            <select name="admin">
                <option value="0">Normal</option>
                <option value="1">Administrator</option>
                <option value="2">Debugger</option>
                <option value="3">Developer</option>
            </select>
            <label>Type of user</label><br />




            <input type="submit" value="Update" name="update"/>

    </form>

</fieldset>

<fieldset>

    <legend>Add a user</legend>

    <form action="./admin/menus/user.php" method="post">

        <b>Add a user:</b><br />

        <input type="text" name="name"/><label>Name</label><br />
        <input type="text" name="email"/><label>Email</label><br />
        <input type="text" name="password"/><label>Password</label><br />
        <select name="type">
            <option value="2">Project Resource</option>
            <option value="1">Project Manager</option>
            <option value="0">Both</option>
        </select>
        <label>Type of resource</label>
        <br />
        <select name="admin">
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

    <form action="./admin/menus/user.php" method="post">

        <b>Select a user:</b><br />
        <select name="index">

            <option value="">Select One:</option>

            <?php

            foreach($people as $person){

                echo '<option value="',$person['index'],'">',$person['name'],'</option>';

            }
            ?>

        </select>

        <input type="submit" value="Delete" name="delete"/><br /><br />

    </form>

</fieldset>