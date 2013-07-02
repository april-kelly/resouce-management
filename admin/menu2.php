<?php

///includes
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//Fetch values to populate fields
$set = new settings;
$settings = $set->fetch();

?>
<div id="admin_head">
    <h3>Administrative Settings:</h3>
    <ul>
        <li><a href="./?p=admin&a=status">System Status</a></li>
        <li><a href="./?p=admin&a=general">General</a></li>
        <li><a href="./?p=admin&a=internal">Internal</a></li>
        <li><a href="./?p=admin&a=users">Users</a></li>
        <?php if($settings['debug'] == true && $_SESSION['admin'] >= '2'){ ?>
            <li><a href="./?p=debug">Debug</a></li>
        <?php } ?>
    </ul>
</div>
<?php
if(isset($_SESSION['a'])){

$admin = $_SESSION['a'];
unset($_SESSION['a']);

}else{

$admin = '';

}

switch($admin){

    CASE "status":
        $page = 'admin/menus/status.php';
        $id = 'status';
    break;

    CASE "general":
        $page = 'admin/menus/main.php';
    break;


    CASE "internal":
        $page = 'admin/menus/internal.php';
    break;

    CASE "users":
        $page = 'admin/menus/users.php';
    break;

    CASE "debug":
        $page = 'admin/menus/debug.php';
    break;

    DEFAULT:
        //Just show the status page
        $page = 'admin/menus/status.php';
    break;

}

if(isset($id)){
    echo '<div id="'.$id.'">';
}
if(!(empty($page))){
    //show the requested page
    include_once(ABSPATH.$page);
}
if(isset($id)){
    echo '</div>';
}

?>