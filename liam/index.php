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

//determine what page to show
switch($request){

    case "home":
        $page = './month.php';
        $main_id = 'main';
    break;

    case "request":
        $page = './request.php';
        $main_id = 'main';
        $extras = TRUE;
    break;

    case "admin":
        $page = './admin/menu.php';
        $main_id = 'main';
    break;

    case "login":
        $page = './admin/index.php';
        $main_id = 'login';
    break;

    case "user":
        $page = './user.php';
        $main_id = 'main';
    break;

    case "logout":
        $page = './admin/index.php';
        $main_id = 'login';
        $_SESSION['logout'] = true; //lets the login page know the user has just logged out
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

            include_once($page);

        ?>

    </div>

</body>
</html>