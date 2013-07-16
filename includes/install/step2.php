<?php

//start the users session
if(!(isset($_SESSION))){
session_start();
}

//Fetch data from step 1
$_SESSION['step1'] = $_REQUEST;

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

    <h1>Step 2: Admin Account</h1><hr />

    <p>
        Now you will create an administrator account for yourself (or for whomever you would like).
    </p>

    <form action="step3.php" method="post">

        <label for="email">Email: </label>               <input type="text" name="email" /><br />
        <label for="first_name">First name: </label>     <input type="text" name="first_name" /><br />
        <label for="last_name">Last name: </label>       <input type="text" name="last_name" /><br />
        <label for="password">Password </label>          <input type="password" name="password" /><br />
        <label for="passwordII">Re-type Password </label><input type="password" name="passwordII" /><br />

        <input type="submit" name="step2" value="Run the install" />
    </form>


</div>

</body>
</html>
