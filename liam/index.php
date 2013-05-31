<?php
/**
 * Name:       Resource Management Base Template
 * Programmer: Liam Kelly
 * Date:       5/31/13
 */

//start the users session
session_start();

//includes
include_once('./data.php');

//fetch the user's request
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = '';
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
        $page = './admin/user.php';
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

        require_once('head_extras.html');

    }

    ?>

</head>
<body>

    <div id="header">

        <img src="./images/logo.gif" style="center"/>

        <?php

            require_once('./nav.php');

        ?>

    </div>

    <div id="<?php echo $main_id;?>">

        <?php

            require_once($page);

        ?>

    </div>

</body>
</html>