<?php

    //Fetch values to populate fields
    $settings = unserialize(file_get_contents('../settings.bin'));
    $db_host = $settings['db_host'];
    $db_user = $settings['db_user'];
    $db_pass = $settings['db_pass'];
    $db_database = $settings['db_database'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Bluetent Resource Management: Admin</title>
</head>
<body>

    <fieldset>

        <legend>User Options</legend>

        <form action="admin.php" method="post">

            <input type="submit" value="Save" />
        </form>

    </fieldset>

    <fieldset>

        <legend>Display Options:</legend>

        <form action="admin.php" method="post">
            <br />

            <b>month.php: </b><br /><br />
            <input type="checkbox" /><label>Enable coloration</label><br />
            <input type="checkbox" /><label>Enable debug mode</label><br />
            <input type="checkbox" /><label>Enable excel output</label><br />
            <input type="text" /><label># of weeks to display</label><br />
            <br />

            <b>insert.php</b><br /><br />
            <input type="checkbox" /><label>Enable user data validation</label><br />
            <input type="checkbox" /><label>Enable user data sensitization</label><br />
            <input type="checkbox" /><label>Enable debug mode</label><br />
            <br />

            <b>data.php</b><br /><br />
            <input type="text" value="<?php echo $db_host; ?>" /><label>Database Hostname</label><br />
            <input type="text" value="<?php echo $db_user; ?>" /><label>Database Username</label><br />
            <input type="password" value="<?php echo $db_pass; ?>" /><label>Database Password</label><br />
            <input type="text" value="<?php echo $db_database; ?>" /><label>Database Name</label><br />
            <br />


            <br />
            <input type="submit" value="Save" />
        </form>

    </fieldset>

    <fieldset>

        <legend>Debugging Options:</legend>

        <form action="admin.php" method="post">

            <input type="submit" value="Save" />
        </form>

    </fieldset>

</body>
</html>