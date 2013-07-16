<?php
/**
 * Name:       resouce-management     
 * Programmer: liam
 * Date:       7/16/13
 */

//start the users session
if(!(isset($_SESSION))){
session_start();
}

//Fetch data from step 2
$_SESSION['step2'] = $_REQUEST;

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

    <h1>Step 3: Installation</h1><hr />

    <p>
        Please wait while we install, this should just take a moment....
    </p>

    <?php

        //We will create the database here
        require_once('./create_db.php');

        create_settings(
            $_SESSION['step1']['db_user'],
            $_SESSION['step1']['db_host'],
            $_SESSION['step1']['db_pass'],
            $_SESSION['step1']['db_database']
        );

        create_db($_SESSION['step1']['db_database']);

    ?>

</div>

</body>
</html>
