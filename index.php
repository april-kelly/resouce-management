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
include_once(ABSPATH.'includes/config/settings.php');

//make sure that the settings file exists
if(!(file_exists('./includes/config/settings.php'))){

    $request = 'config';

}else{

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

    //Ensure the settings file is not "corrupt"
    if(!($settings['mlp'] == 'awesome')){
        $request = '403';
    }

}

//make sure that the settings file exists
if(!(file_exists('./includes/config/settings.json'))){
    $request = "config";
}

//make sure that the database credinitals are defined
if(!(isset($settings['db_database']))){
    $request = "config";
}

//Maintenance mode
if($settings['maintenance'] == TRUE && $_SESSION['admin'] <= 0){

  if(!($request == 'login')){
      $request = 'down';
}

}elseif($settings['maintenance'] == TRUE && $_SESSION['admin'] >= 1){

    header($_SERVER['SERVER_PROTOCOL']." 503 Down for maintenance");

}

//Strict mode (no anonymous users)
if($settings['strict'] == TRUE && !(isset($_SESSION['userid']))){

    if(!($request == 'badlogin' or $request == "banned" or $request == "login")){

        $request = 'login';

    }

}

//Beta mode
if($settings['production_alert'] == TRUE && !(isset($_SESSION['beta'])) && $settings['production'] == false){

    if(!($request == 'badlogin' or $request == "banned" or $request == "login")){

        $request = 'beta';

    }


}

/*
//Two Step Authentication
if($settings['IIstep'] == TRUE && !(empty($_SESSION['userid'])) && isset($_SESION['auth_code'])){

    if(!($request == 'badlogin' or $request == "banned" or $request == "login")){

        //Forward user to Code generation
        header('location: ./includes/twofactor/test.php');

    }

}
*/

//Deal with the last page
if($request == "last_page"){

    $request = $_SESSION['last_page'];

}

//determine what page to show
switch($request){

    //View Requests
    case "view_requests":
        $page = './includes/view_requests.php';
        $main_id = 'profile';
        $last_page = 'view_requests';
        $title = '<h3>My Requests</h3>';
    break;


    //Alert the user that this server is a teapot
    case "brew":
        $page = './includes/errors/418.php';
        $main_id = 'profile';
        $last_page = 'brew';
    break;

    //In the event that the settings file(s) are corrupt
    case "403":
        $page = './includes/errors/403.php';
        $main_id = 'profile';
        $last_page = '403';
    break;

    //Add/Edit a project
    case "project":

        //pass project id (if set)
        if(isset($_REQUEST['id'])){
            $_SESSION['project_id'] = $_REQUEST['id'];
        }

        $page = './includes/project.php';
        $last_page = 'project';
        $main_id = 'profile';
    break;

    //Edit profile pic
    //If the server is a beta release
    case "edit_pic":

        //if the server is in beta mode
        if($settings['production'] == FALSE){

            $page = './includes/update_pic.php';

        }

        //pass pagination  (if set)
        if(isset($_REQUEST['wrong_type'])){
            $_SESSION['wrong_type'] = $_REQUEST['wrong_type'];
        }
        $last_page = 'edit_pic';
        $main_id = 'profile';

        break;

    //If the server is a beta release
    case "beta":

        //if the server is in beta mode
        if($settings['production'] == FALSE){

            $page = './includes/errors/beta.php';

        }
        $last_page = 'break';
        $main_id = 'profile';

    break;

    case "down":
        //if the server is in maintenance mode
        if($settings['maintenance'] == TRUE){

            $page = './includes/errors/503.php';

        }
        $last_page = 'down';
        $main_id = 'main';
    break;

    //Recover Passwords
    case "reset_code":
        $page = './admin/reset_user.php';
        $last_page = 'reset_code';
        $main_id = 'login';

        //pass reset code (if set)
        if(isset($_REQUEST['c'])){
            $_SESSION['reset_code'] = $_REQUEST['c'];
        }
    break;

    //Recover/Reset the settings
    case "reset":
        $page = './includes/config/reset.php';
        $last_page = 'reset';
        $main_id = 'profile';
    break;

    //this is for temporary debugging (to be removed)
    case "test":
        $page = './includes/test.php';
        $last_page = 'test';
        $main_id = 'main';
    break;

    case "config":
        //Because things break when dependencies are not installed we will just redirect
        header('location: ./includes/install/index.php');
    break;

    case "home":
        $page = './includes/overview.php';
        $main_id = 'main';
        $last_page = 'home';

        //pass pagination  (if set)
        if(isset($_REQUEST['page'])){
            $_SESSION['page'] = $_REQUEST['page'];
        }

        $title = '<h3>Current Resource Utilization:</h3>';
    break;

    case "search":
        $page = './includes/search_frontend.php';
        $last_page = 'search';
        $main_id = 'search';

        //pass any searches (if set)
        if(isset($_REQUEST['q'])){
            $_SESSION['q'] = $_REQUEST['q'];
        }
    break;

    case "request":
        $page = './includes/request.php';
        $last_page = 'request';
        $main_id = 'profile';
        $extras = TRUE;

        //pass any errors (if set)
        if(isset($_REQUEST['r'])){
            $_SESSION['form'] = $_REQUEST['r'];
        }
    break;

    case "admin":

        $page = './admin/menu.php';
        $last_page = 'admin';
        $main_id = 'admin';

        //pass the save status (if set)
        if(isset($_REQUEST['s'])){
            $_SESSION['saved'] = $_REQUEST['s'];
        }

        //pass the admin page request (if set)
        if(isset($_REQUEST['a'])){
            $_SESSION['a'] = $_REQUEST['a'];
        }

        //pass reset code (if set)
        if(isset($_REQUEST['c'])){
            $_SESSION['reset_code'] = $_REQUEST['c'];
        }

        //pass the userid to look up (if set)
        if(isset($_REQUEST['u'])){
            $_SESSION['user_lookup'] = $_REQUEST['u'];
        }

    break;

    case "login":
        $page = './admin/login_form.php';
        $last_page = 'login';
        $main_id = 'login';
    break;

    case "badlogin":
        $page = './admin/login_form.php';
        $last_page = 'badlogin';
        $main_id = 'login';

        $_SESSION['bad'] = '';
    break;

    case "banned":
        $page = './admin/login_form.php';
        $last_page = 'badlogin';
        $main_id = 'login';

        $_SESSION['banned'] = '';
    break;

    case "user":
        $page = './includes/profile.php';
        $last_page = 'user';
        $main_id = 'profile';
    break;

    case "week":
        $page = './includes/week.php';
        $last_page = 'week';
        $main_id = 'main';

        //pass the requested user id to week.php (if set)
        if(isset($_REQUEST['w'])){
            $_SESSION['person'] = $_REQUEST['w'];
        }

        //pass the edit flag (if set)
        if(isset($_REQUEST['e'])){
            $_SESSION['edit'] = $_REQUEST['e'];
        }

        //pass the index of the item to be deleted (if set)
        if(isset($_REQUEST['d'])){
            $_SESSION['d'] = $_REQUEST['d'];
        }
    break;

    case "logout":
        $page = './admin/login_form.php';
        $last_page = 'logout';
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

            $page = './admin/menus/debug.php';
            $main_id = 'main';

            //pass the debug options back to debug.php (if set)
            if(isset($_REQUEST['d'])){
                $_SESSION['debug'] = $_REQUEST['d'];
            }

        }else{

            //send the user to the home page
            header('location: ./');

        }
        $last_page = 'debug';

    break;

    case "505":
        $page = './includes/errors/505.php';
        $last_page = 'login';
        $main_id = 'main';
    break;

    default:
        $page = './includes/errors/404.php';
        $last_page = '';
        $main_id = 'main';
    break;

}

//More of the last_page
$_SESSION['last_page'] = $_SESSION['current_page'];
$_SESSION['current_page'] = $request;


//Make sure that the user's session has not timed out
if($_SESSION['timeout'] == true){

    $page = './admin/login_form.php';
    unset($title);
    $main_id = "login";

}

?>
<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="./includes/styles/styles.css" type="text/css" />
    <link rel="icon" href="./includes/images/btm_favicon.ico" />

    <meta charset="UTF-8">
    
    <?php

    if(isset($extras)){

        include_once('./includes/head_extras.html');

    }

    ?>

</head>
<body>

    <div id="header">

        <img src="<?php echo $settings['logo']; ?>" style="center" alt="Bluetent Marketing"/>

        <?php

            include_once('./includes/nav.php');

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

    <div id="footer">

        <?php

            //Destroy old form data
            if(isset($_SESSION['input'])){

                unset($_SESSION['input']);

            }

            include_once(ABSPATH.'includes/footer.php');

        ?>

    </div>

</body>
</html>