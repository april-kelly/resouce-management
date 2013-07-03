<?php
/**
 * Name:
 * Programmer: Liam Kelly
 * Date:       7/2/13
 */

///includes
require_once('../../path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');

//Fetch values to populate fields
$set = new settings;
$settings = $set->fetch();

//Setup the user abstraction layer
$users = new users;

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){
    if($_SESSION['admin'] >= 1){

        //User is logged in


var_dump($_REQUEST);

//Delete a user
if(isset($_REQUEST['delete'])){
    $users->change('index', $_REQUEST['index']);
    $users->delete();
    echo 'attempted delete';
}

//add a user
if(isset($_REQUEST['add'])){

    $users->change('index', null);
    $users->change('name', $_REQUEST['name']);
    $users->change('email', $_REQUEST['email']);
    $users->change('password', $_REQUEST['password']);
    $users->change('type', $_REQUEST['type']);
    $users->change('admin', $_REQUEST['admin']);

    $users->create();
    echo 'attempted update';
}

//update user
if(isset($_REQUEST['update'])){

    $users->change('index', $_REQUEST['userid']);

    $users->change('name', $_REQUEST['name']);
    $users->change('email', $_REQUEST['email']);
    $users->change('password', $_REQUEST['password']);
    $users->change('type', $_REQUEST['type']);
    $users->change('admin', $_REQUEST['admin']);

    $users->update();
    echo 'attempted update';
}

}else{

    //User is not admin
    ?><span class="error">You must be an administrator to access this page.</span><?php

}

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}