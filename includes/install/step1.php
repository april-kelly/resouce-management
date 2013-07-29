<?php

//start the users session
if(!(isset($_SESSION))){
    session_start();
}


?>

<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="../styles/styles.css" type="text/css" />
    <link rel="icon" href="../images/btm_favicon.ico" />


</head>
<body>

<div id="installer">

    <h1>Step 1: Server Information</h1><hr />

    <p>
        Alright, the first thing you will need is the login info for the database account you plan to let us use.
        You can get this from you web host. In addition know what your domain name and installation directory are.
    </p>

    <form action="step2.php" method="post">

        <b>Database:</b><br /><br />
        <label for="db_host">Database Host: </label><input type="text" name="db_host" /><br />
        <label for="db_user">Database Username: </label><input type="text" name="db_user" /><br />
        <label for="db_pass">Database Password: </label><input type="password" name="db_pass" /><br />
        <label for="db_database">Database Name: </label><input type="text" name="db_database" value="Resources" /><br />

        <br /><b>Server information: </b><br /><br />
        <label for="db_host">Domain name: </label><input type="text" name="server_domain" /><br />
        <label for="db_host">Installation Directory: </label><input type="text" name="server_dir" /><br />

        <input type="submit" name="step1" value="Next" />
    </form>


</div>

</body>
</html>
