<?php
/**
 * Name:       Resource Management Base Template
 * Programmer: Liam Kelly
 * Date:       5/31/13
 */

//start the users session
session_start();

//includes
require_once('path.php');
require_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$settings = $set->fetch();

//error reporting
if($settings['debug'] == TRUE){
    error_reporting(E_STRICT);
}else{
    error_reporting(0);
}

//fetch the user's request
if(isset($_REQUEST['p'])){
    $request = $_REQUEST['p'];
}else{
    $request = 'home';
}

//make sure that the settings file exists
if(!(file_exists('./includes/config/settings.json'))){
    $request = "config";
}

//determine what page to show
switch($request){

    case "config":
        $page = './includes/config/welcome.php';
        $main_id = 'profile';

        //pass extra values to welcome.php (if set)
        if(isset($_REQUEST['c'])){
            $_SESSION['c'] = $_REQUEST['c'];
        }

    break;

    case "home":
        $page = './includes/month.php';
        $main_id = 'main';
        $title = '<h3>Current Resource Utilization:</h3>';
    break;

    case "request":
        $page = './includes/request.php';
        $main_id = 'profile';
        $extras = TRUE;

        //pass any errors (if set)
        if(isset($_REQUEST['r'])){
            $_SESSION['form'] = $_REQUEST['r'];
        }
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
        $page = './admin/login_form.php';
        $main_id = 'login';
    break;

    case "badlogin":
        $page = './admin/login_form.php';
        $main_id = 'login';
    break;

    case "user":
        $page = './includes/user.php';
        $main_id = 'profile';
    break;

    case "week":
        $page = './includes/week.php';
        $main_id = 'main';

        //pass the requested user id to week.php (if set)
        if(isset($_REQUEST['w'])){
            $_SESSION['person'] = $_REQUEST['w'];
        }
    break;

    case "logout":
        $page = './admin/login_form.php';
        $main_id = 'login';

        //Destroy and recreate the session
        session_destroy();
        session_start();

        //Trigger the login page to display a log out message.
        $_SESSION['logout'] = true;
    break;

    case "debug":

        //make sure debug mode is actually enabled
        if($settings['debug'] == true){

            $page = './includes/debug.php';
            $main_id = 'main';

            //pass the debug options back to debug.php (if set)
            if(isset($_REQUEST['d'])){
                $_SESSION['debug'] = $_REQUEST['d'];
            }

        }else{

            //send the user to the home page
            header('location: ./');

        }

    break;

    default:
        $page = './includes/month.php';
        $main_id = 'main';
    break;

}

?>
<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="./includes/styles/styles.css" type="text/css" />
    <link rel="icon" href="./includes/images/btm_favicon.ico" />

    <?php

    if(isset($extras)){

        include_once('./includes/head_extras.html');

    }

    ?>

</head>
<body>

    <div id="header">

        <img src="./includes/images/logo.gif" style="center"/>

        <?php

            include_once('./includes/nav.php');

        ?>

    </div>

    <div id="<?php echo $main_id;?>">


        <?php

            //if debug mode is enabled let the user know
            if($settings['debug'] == true){
                echo '<span class="info">Debug mode has been enabled.</span>';
            }
            //if a title is set echo it out
            if(!(empty($title))){
                echo $title;
            }

            //include the page
            include_once($page);

        ?>

    </div>

    <div id="footer">

        <?php

            include_once(ABSPATH.'includes/footer.php');

        ?>

    </div>

</body>
</html>