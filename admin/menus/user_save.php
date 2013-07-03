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