<?php

//includes
include_once(ABSPATH.'includes/config/settings.php');

//fetch the debug status
$set = new settings;
$status = $set->fetch();


?>
<ul>
    <li><a href="./?p=home">Overview</a></li>
    <li><a href="./?p=request">Request</a></li>
    <?php if($_SESSION['admin'] == '1'){ ?>
    <li><a href="./?p=admin">Settings</a></li>
    <?php } ?>
    <?php if($status['debug'] == true && $_SESSION['admin'] == '1'){ ?>
        <li><a href="./?p=debug">Debug</a></li>
    <?php } ?>
    <?php if(!(isset($_SESSION['name']))){ ?>
    <li><a href="./?p=login">Login</a></li>
    <?php }else{ ?>
    <li><a href="./?p=user">Hi, <?php echo $_SESSION['name']; ?></a></li>
    <?php } ?>

</ul>
