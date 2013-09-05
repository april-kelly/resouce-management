<?php

/**
 * Name:       Resource Management Two Factor Authentication
 * Programmer: Liam Kelly
 * Date:       8/15/13
 */
//Setup the session
if(!(isset($_SESSION))){
    session_start();
}

//Define ABSPATH
if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}

//Includes
require_once(ABSPATH.'includes/twofactor/class.googlevoice.php');
require_once(ABSPATH.'admin/generate_reset_codes.php');
require_once(ABSPATH.'includes/config/users.php');
require_once(ABSPATH.'includes/config/settings.php');

//Fetch the settings
$set = new settings;
$settings = $set->fetch();

//Make sure Two Factor Authentication is actually enabled
if($settings['IIstep'] == true){

    //Generate code and message
    $auth_code = create_auth_code();
    $message = "Your authentication code is: ".$auth_code." ";
    $_SESSION['auth_code'] = $auth_code;

    //Fetch the users phone number
    $users = new users;
    $user_info = $users->select($_SESSION['ref']);
    $user_info = $user_info[0];

    if(!($user_info == false) && !(empty($user_info['phone_number']))){

        //Send the text message
        if(!(empty($user_info['phone_number']))){

            //Make sure the google voice account creds exist
            if(!(empty($settings['gv_account'])) && !(empty($settings['gv_password']))){

                $gv = new GoogleVoice($settings['gv_account'], $settings['gv_password']);
                $gv->sms($user_info['phone_number'], $message);

            }else{

                echo 'Unable to connect to Google Voice (Please define account creds in settings.php)';
                header('location: ../../admin/login.php?auth_code='.$_SESSION['auth_code']);
                $fail = true;

            }

        }

    }else{

        unset($_SESSION['auth_code']);
        //unset($_SESSION['ref']);

    }

    if(!(isset($fail))){

        //Send the user to the login form
        header('location: ../../?p=login');

    }


}else{

    //Disabled redirect user to the last page they were on.
    //header('location: ../../?p=last_page');

}


