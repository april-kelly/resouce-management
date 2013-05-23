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
    $settings = new settings;
    $settings = $settings->fetch();
    $db_host = $settings['db_host'];
    $db_user = $settings['db_user'];
    $db_pass = $settings['db_pass'];
    $db_database = $settings['db_database'];

if($settings['insert_fail'] == TRUE)
{
    echo "checked";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Bluetent Resource Management: Admin</title>
</head>
<body>

    <p>

        <h2>Administrative Control Panel:</h2>
        <b>Welcome, <?php echo $user[0]['name'] ?> <a href="./login.php?logout">(logout)</a></b>

    </p>

    <fieldset>

        <legend>Display and Debugging Options:</legend>

        <form action="save.php" method="post">
            <br />

            <b>month.php: </b><br /><br />
            <input type="checkbox"
                <?php if($settings['month_debug'] == TRUE){ echo "checked"; } ?>
                /><label>Enable debug mode</label><br />
            <input type="checkbox"
                <?php if($settings['month_colors'] == TRUE){ echo "checked"; } ?>
                /><label>Enable coloration</label><br />
            <input type="checkbox"
                <?php if($settings['month_excel'] == TRUE){ echo "checked"; } ?>
                /><label>Enable excel output</label><br />
            <input type="checkbox"
                <?php if($settings['month_output'] == TRUE){ echo "checked"; } ?>
                /><label>Enable output</label><br />
            <input type="text" value="<?php echo $settings['weeks'] ?>" /><label># of weeks to display</label><br />
            <br />


            <b>insert.php</b><br /><br />
            <input type="checkbox"
                <?php if($settings['insert_debug'] == TRUE){ echo "checked"; } ?>
                /><label>Enable debug mode</label><br />
            <input type="checkbox"
                <?php if($settings['insert_valid'] == TRUE){ echo "checked"; } ?>
                /><label>Enable user data validation</label><br />
            <input type="checkbox"
                <?php if($settings['insert_sanitize'] == TRUE){ echo "checked"; } ?>
                /><label>Enable user data sanitation</label><br />
            <input type="checkbox"
                <?php if($settings['insert_fail'] == TRUE){ echo "checked"; } ?>
                /><label>Force insert to fail</label><br />
            <br />


            <b>data.php</b><br /><br />
            <input type="text" value="<?php echo $db_host; ?>" /><label>Database Hostname</label><br />
            <input type="text" value="<?php echo $db_user; ?>" /><label>Database Username</label><br />
            <input type="password" value="<?php echo $db_pass; ?>" /><label>Database Password</label><br />
            <input type="text" value="<?php echo $db_database; ?>" /><label>Database Name</label><br />
            <br />


            <br />
            <input type="submit" value="Update" />
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

</body>
</html>