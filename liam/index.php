<?php
/**
 * Name:       Resource Management Base Template
 * Programmer: Liam Kelly
 * Date:       5/31/13
 */

//start the users session
session_start();

//create the location constant
define('ABSPATH', dirname(__FILE__));

//fetch the user's request
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}

//make sure that the settings file exists
if(!(file_exists('./config/settings.json'))){
    $request = "config";
}

//determine what page to show
switch($request){

    case "config":
        $page = './config/welcome.php';
        $main_id = 'profile';

        //pass extra values to welcome.php (if set)
        if(isset($_REQUEST['c'])){
            $_SESSION['c'] = $_REQUEST['c'];
        }

    break;

    case "home":
        $page = './month.php';
        $main_id = 'main';
        $title = '<h3>Current Resource Utilization:</h3>';
    break;

    case "request":
        $page = './request.php';
        $main_id = 'profile';
        $extras = TRUE;
    break;

    case "admin":

        $page = './admin/menu.php';
        $main_id = 'admin';

        //pass the save status (if set)
        if(isset($_REQUEST['s'])){
            $_SESSION['saved'] = $_REQUEST['s'];
        }

    break;

    case "login":
        $page = './admin/index.php';
        $main_id = 'login';
    break;

    case "user":
        $page = './user.php';
        $main_id = 'profile';
    break;

    case "week":
        $page = './week.php';
        $_SESSION['person'] = $_REQUEST['w']; //this lets week.php know what user to show
        $main_id = 'main';
    break;

    case "logout":
        $page = './admin/index.php';
        $main_id = 'login';

        //Destroy and recreate the session
        session_destroy();
        session_start();

        //Trigger the login page to display a log out message.
        $_SESSION['logout'] = true;
    break;

    case "debug":
        $page = base64_decode($_REQUEST['r']);
        $main_id = 'main';
    break;

    default:
        $page = './month.php';
        $main_id = 'main';
    break;

}

?>
<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="./styles/styles.css" type="text/css" />
    <link rel="icon" href="./images/btm_favicon.ico" />

    <?php

    if(isset($extras)){

        include_once('head_extras.html');

    }

    ?>

</head>
<body>

    <div id="header">

        <img src="./images/logo.gif" style="center"/>

        <?php

            include_once('./nav.php');

        ?>

    </div>

    <div id="<?php echo $main_id;?>">

        <?php
            //if a title is set echo it out
            if(!(empty($title))){
                echo $title;
            }

            //include the page
            include_once($page);

        ?>

    </div>

</body>
</html>