<?php

//includes
include_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->debug;


?>
<ul>
    <li><a href="./?p=home">Overview</a></li>
    <li><a href="./?p=request">Request</a></li>
    <li><a href="./?p=admin">Settings</a></li>
    <?php if(!(isset($_SESSION['name']))){ ?>
    <li><a href="./?p=login">Login</a></li>
    <?php }else{ ?>
    <li><a href="./?p=user">Hi, <?php echo $_SESSION['name']; ?></a></li>
    <?php } if($status == true){ ?>
    <li><a href="./?p=debug">Debug</a></li>
    <?php } ?>
</ul>
