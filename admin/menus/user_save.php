<?php
/**
 * Name:
 * Programmer: Liam Kelly
 * Date:       7/2/13
 */

//Make sure the session has started
if(!(isset($_SESSION))){
    session_start();
}

//includes
require_once('../../path.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/config/users.php');
require_once(ABSPATH.'admin/generate_reset_codes.php');

//Fetch values to populate fields
$set = new settings;
$settings = $set->fetch();

//Setup the user abstraction layer
$users = new users;

//make sure the user is logged in and is admin
if(isset($_SESSION['userid'])){

    if($_SESSION['admin'] >= 1){

        //User is logged in

        //Reset a user's password
        if(isset($_REQUEST['reset'])){
            $reset_code = insert_reset_code($_REQUEST['userid']);
            $users->select($_REQUEST['userid']);
            //Corrupt the user's password
            //(this forces them to use the rest code and stops anyone else from using their password until they do)
            $users->change('password', '25b57c6a8f9d1a4eb787430006db8d45c2081652b4369cc5cd05917445a7a536ae60fb3d5a75eff167599e1507cceb08b2790b8ea9f6d0ccebf35fde177789c9');
            $users->update();
            echo 'attemped password reset';

            header('Location: ../../?p=admin&a=users&c='.$reset_code);
        }

        //Delete a user
        if(isset($_REQUEST['delete'])){
            $users->change('index', $_REQUEST['index']);
            $users->delete();
            echo 'attempted delete';

            header('Location: ../../?p=admin&a=users');
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
            echo 'attempted add';

            header('Location: ../../?p=admin&a=users');
        }

        //update user
        if(isset($_REQUEST['update'])){

            $users->change('index', $_REQUEST['userid']);

            $users->change('name', $_REQUEST['name']);
            $users->change('email', $_REQUEST['email']);
            //$users->change('password', $_REQUEST['password']);
            $users->change('type', $_REQUEST['type']);
            $users->change('admin', $_REQUEST['admin']);

            $users->update();
            echo 'attempted update';

            header('Location: ../../?p=admin&a=users');
        }


    }else{

        //User is not admin
        ?><span class="error">You must be an administrator to access this page.</span><?php

    }

}else{

    //User is not logged in
    ?><span class="error">You are not logged in, please login to access this page.</span><?php

}