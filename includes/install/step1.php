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

    <h1>Step 1: Database Information</h1><hr />

    <p>
        Alright, the first thing you will need is the login info for the database account you plan to let us use.
        You can get this from you web host.
    </p>

    <form action="step2.php" method="post">

        <label for="db_host">Database Host: </label><input type="text" name="db_host" /><br />
        <label for="db_user">Database Username: </label><input type="text" name="db_user" /><br />
        <label for="db_pass">Database Password: </label><input type="password" name="db_pass" /><br />
        <label for="db_database">Database Name: </label><input type="text" name="db_database" value="Resources" /><br />

        <input type="submit" name="step1" value="Next" />
    </form>


</div>

</body>
</html>
