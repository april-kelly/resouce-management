<?php
//start the users session
if(!(empty($_SESSION))){
    session_start();
}


//includes
include_once(dirname(__FILE__).'/data.php');

//fetch info about the user (if logged in)
if(isset($_SESSION['userid'])){
    $dbc = new db;
    $dbc->connect();
    $user = $dbc->query("SELECT * FROM people WHERE `index`='".$_SESSION['userid']."'");
    $dbc->close();
}



?>
<ul>
    <li><a href="./dashboard.php">Overview</a></li>
    <li><a href="./index.php">Request</a></li>
    <li><a href="./admin/admin.php">Settings</a></li>
    <?php if(!(isset($_SESSION['userid']))){ ?>
    <li><a href="./admin/index.php">Login</a></li>
    <?php }else{ ?>
    <li><a href="./admin/user.php">Hi, <?php echo $user[0]['name']; ?></a></li>
    <?php } ?>
</ul>

