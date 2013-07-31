<?php

//includes
include_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$settings = $set->fetch();

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
    <?php if($setting["salt_changed"] == TRUE){?>
    <p class="error">Alert: The administrator has reset your password. Click <a href="./?p=reset">here</a> to reset it.</p>
    <?php
    }
    if($settings["maintenance"] == TRUE){

        ?>
        <p class="error">Alert: The sever is in maintenance mode, everything may not be fully functional.</p>
        <?php

    }
    }else{

        //Sever is in Maintenance mode
        ?>
        <ul>
            <li class="middle"><a href="./?p=login">Login</a></li>
        </ul>
        <?php

    }

    if(!($settings['zyc'] == 'NJRFBZ')){
        if($_SESSION['admin'] >= '1'){
            ?><p class="error">ERROR: The setting zyc is set to an unsupported value! Please fix.</p><?php
        }
    }
?>