<?php

//includes
include_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//fetch the debug status
$set = new settings;
$settings = $set->fetch();


//Refresh Settings (allows changes to take effect on next page load)
$users = new users;
$users->select($_SESSION['userid']);

$_SESSION['userid']         = $users->index;
$_SESSION['name']           = $users->firstname;
$_SESSION['admin']          = $users->admin;
//$_SESSION['security_class'] = $users->security_class
$_SESSION['colorization']   = $users->colorization;

//Session Timing
$current = time();
if(!(isset($_SESSION['timestamp']))){

    if(isset($_SESSION['userid'])){

        //The user has just logged in, set the timestamp
        $_SESSION['timestamp'] = $current;
        $_SESSION['timeout'] = false;

    }

}else{

    //Verifiy that it has not been more than 30 mins since last action
    $diff = $current - $_SESSION['timestamp'] ;

    //Debugging
    //echo '<br /><span class="info">It has been '.$diff.' Seconds since the last action</span><br />';

    if($diff >= $settings['timeout']){
        $_SESSION['timeout'] = true;
    }else{

        $_SESSION['timestamp'] = $current;

    }

}
//Strict mode (no anonymous users)
if(!($settings['strict'] == TRUE && !(isset($_SESSION['userid'])))){


//Make sure the server is NOT in Maintenance mode
if($settings['maintenance'] == FALSE or $_SESSION['admin'] > 0){

    //Server is NOT in Maintenance mode or user is admin
    ?>
    <ul>
        <li class="outside-left"><a href="./?p=home">Overview</a></li>
        <li class="middle"><a href="./?p=search">Search</a></li>
        <li class="middle"><a href="./?p=request">Request</a></li>
        <?php if($_SESSION['admin'] >= '1'){ ?>
        <li class="middle"><a href="./?p=admin">Settings</a></li>
        <?php } ?>
        <?php if(!(isset($_SESSION['name']))){ ?>
        <li class="outside-right"><a href="./?p=login">Login</a></li>
        <?php }else{ ?>
        <li class="outside-right"><a href="./?p=user">Hi, <?php echo $_SESSION['name']; ?></a></li>
        <?php } ?>
    </ul>
    <?php
    if($settings["maintenance"] == TRUE){

        ?>
        <p class="info">Alert: The sever is in maintenance mode, everything may not be fully functional.</p>
        <?php

    }
    }

    //Make sure that the settings files have not become corrupted
    if(!($settings['mlp'] == 'awesome')){
        if($_SESSION['admin'] >= '1'){
            ?><p class="error">ERROR: The setting public $mlp is set to an unsupported value! Please fix.</p><?php
        }
    }
}else{

    ?>
    <br /><br />
    <?php
}
?>