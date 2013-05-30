<?php

    //includes
    include_once('../data.php');

    //fectch user info
    $dbc = new db;
    $dbc->connect();
    $user = $dbc->query("SELECT * FROM people WHERE `index`='".$_SESSION['userid']."'");
    $resources = $dbc->query("SELECT * FROM people");
    $dbc->close();

    //Fetch values to populate fields
    $set = new settings;
    $settings = $set->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bluetent Resource Management: Admin</title>
    <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>
<div id="header">

    <img src="../images/logo.gif" style="center"/>

    <ul>
        <li><a href="../dashboard.php">Overview</a></li>
        <li><a href="../index.php">Request</a></li>
        <li><a href="./index.php">Login</a></li>
        <li><a href="./admin.php">Settings</a></li>
    </ul>

</div>

<div id="main">
        <h3>Administrative Control Panel:</h3>
        <b>Welcome, <?php echo $user[0]['name'] ?> <a href="./login.php?logout">(logout)</a></b>



    <fieldset>

        <legend>Display and Debugging Options:</legend>

        <form action="save.php" method="post"><br />

            <b>month.php: </b><br /><br />

            <input type="hidden" name="month_debug" value="FALSE" />
            <input type="checkbox" name="month_debug" value="TRUE" <?php if($settings['month_debug'] == TRUE){ echo "checked"; } ?> />
            <label>Enable debug mode</label><br />
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


            <b>insert.php</b><br /><br />

            <input type="hidden" name="insert_debug" value="FALSE" />
            <input type="checkbox" name="insert_debug" value="TRUE" <?php if($settings['insert_debug'] == TRUE){ echo "checked"; } ?> />
                <label>Enable debug mode</label><br />
            <input type="hidden" name="insert_valid" value="FALSE" />
            <input type="checkbox" name="insert_valid" value="TRUE" <?php if($settings['insert_valid'] == TRUE){ echo "checked"; } ?> />
                <label>Enable user data validation</label><br />
            <input type="hidden" name="insert_sanitize" value="FALSE" />
            <input type="checkbox" name="insert_sanitize" value="TRUE" <?php if($settings['insert_sanitize'] == TRUE){ echo "checked"; } ?> />
                <label>Enable user data sanitation</label><br />
            <input type="hidden" name="insert_fail" value="FALSE" />
            <input type="checkbox" name="insert_fail" value="TRUE" <?php if($settings['insert_fail'] == TRUE){ echo "checked"; } ?> />
                <label>Force insert to fail</label><br />


            <b>data.php</b><br /><br />
            <input type="text" name="db_host" value="<?php echo $settings['db_host']; ?>" /><label>Database Hostname</label><br />
            <input type="text" name="db_user" value="<?php echo $settings['db_user']; ?>" /><label>Database Username</label><br />
            <input type="password" name="db_pass" value="<?php echo $settings['db_pass']; ?>" /><label>Database Password</label><br />
            <input type="text" name="db_database" value="<?php echo $settings['db_database']; ?>" /><label>Database Name</label><br />
            <br />


            <br />
            <input type="submit" value="Update" />
            <?php

                if(isset($_REQUEST['success'])){
                    echo '<span style="color:green">Settings saved successfully!</span>';
                }

                if(isset($_REQUEST['failure'])){
                    echo '<span style="color:red">Error: Unable to save settings!</span>';
                }

            ?>


        </form>

    </fieldset>

    <fieldset>

        <legend>User Options</legend>

        <form action="admin.php" method="post">

            <b>Delete a user:</b><br />
            <select>

                <option value="">Select One:</option>

                <?php
                foreach($resources as $resources){

                    echo '<option value="',$resources['index'],'">',$resources['name'],'</option>';

                }
                ?>

            </select>
            <input type="submit" value="Delete" /><br /><br />

            <b>Add a user:</b><br />
            <input type="text" /><label>Name</label><br />
            <input type="text" /><label>Email</label><br />
            <input type="text" /><label>Password</label><br />
            <select>
                <option value="">Select one:</option>
                <option value="1">Project Manager</option>
                <option value="2">Project Resource</option>
                <option value="0">Other</option>
            </select>
            <label>Type of user</label>
            <br />
            <input type="checkbox" /><label>Is admin?</label><br />



            <input type="submit" value="Add" />
        </form>

    </fieldset>

    <fieldset>

        <legend>Settings Options</legend>

        <form action="save.php" method="post">
            <b>Core Settings:</b><br />
            <input type="submit" value="Rebuild" name="rebuild" /><label>Rebuild the settings file from preset defaults</label>
            <?php

            if(isset($_REQUEST['rebuilt'])){
                echo '<span style="color:green">Settings file rebuilt successfully!</span>';
            }

            ?><br />
            <input type="submit" value="Dump" name="dump" /><label>Dump the contents of the settings file</label><br /><br />

        </form>

    </fieldset>
<div/>
</body>
</html>