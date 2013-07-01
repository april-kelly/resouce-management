<?php
/**
 * Name:       Settings updater.
 * Programmer: liam
 * Date:       5/21/13
 */

//includes
require_once('../path.php');
require_once(ABSPATH.'includes/config/settings.php');
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'admin/users.php');

//Start the users session if nessary
if(!(isset($_SESSION))){
    session_start();
}

//fetch the settings
$set = new settings;
$settings = $set->fetch();

//flags
$fail = TRUE;
$save = TRUE;


//Begin administrator ONLY section
if($_SESSION['admin'] >= '1' && !(isset($_REQUEST['userid']))){

//output debugging info on request
if(isset($_REQUEST['dump'])){
?>
    <h1>Settings Debugging information</h1>
    <hr />
    <b>JSON:</b>
    <pre>
<?php
    echo file_get_contents($set->location);
?>
   </pre>
   <b>Associative Array:</b>
   <pre>
<?php
    var_dump($set->fetch());
?>
   </pre>
   <hr />
   <a href="./admin.php">Go back</a>
<?php

    $save = FALSE; //prevent redirection
}

//Rest the settings file to defaults on request
if(isset($_REQUEST['rebuild'])){

    $set->create();

    header('location: ../?p=admin?s=3');

    $save = FALSE;
}

if(isset($_REQUEST['download'])){

    header('location: ../includes/config/settings.json');
    $save = FALSE;
}

//update each of the settings
foreach($_REQUEST as $key => $value){

    if(isset($settings[$key])){

        switch($value){

            CASE 'TRUE':

                $settings[$key] = TRUE; //this ensures a boolean is saved

            break;

            CASE 'FALSE':

                $settings[$key] = FALSE; //this ensures a boolean is saved

            break;

            DEFAULT:

                $settings[$key] = $value; //normal method (for strings)

            break;
        }

    }

}


//Debug mode enable/disable
if(isset($_REQUEST['d'])){

    if($_REQUEST['d'] == '1'){

        //Enable debug mode
        $settings['debug'] = TRUE;
        $set->update($settings);

    }

    if($_REQUEST['d'] == '0'){

        //Disable debug mode
        $settings['debug'] = FALSE;
        $set->update($settings);


    }
}

if($save == TRUE){ //prevent unnecessary updates

    //update the settings
    $fail = $set->update($settings);

    //Redirect the user back to the settings menu
    if($fail == TRUE){
        header('location: ../?p=admin&s=1');
    }else{
        header('location: ../?p=admin&s=0');
    }
}
//end administrator only section
}


//Begin user section

//User profile updates
if($_REQUEST['userid']){
    echo "Entered user mode";

    $users = new users();

    $status = $users->login($_REQUEST['email'], $_REQUEST['password']);

    //password change
    if(isset($_REQUEST['new_pass'])){
        if(isset($_REQUEST['new_pass_II'])){
            if($_REQUEST['new_pass'] == $_REQUEST['new_pass_II']){
                $users->change('password', sha1($_REQUEST['new_pass']));
                $users->update();
            }
        }
    }

    var_dump($status);

}




