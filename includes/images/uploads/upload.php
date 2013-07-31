<?php
/**
 * Name:       resouce-management     
 * Programmer: liam
 * Date:       7/31/13
 */
//Start the user's session
if(!(isset($_SESSION))){
    session_start();
}
require_once('../../../path.php');
require_once(ABSPATH.'includes/config/users.php');

if(isset($_FILES)){

    if($_FILES["file"]["size"] <= 8388608){

        if(!(file_exists($_FILES["file"]["name"]))){

            //No file exist by this name (yet) so save the upload
            move_uploaded_file($_FILES["file"]["tmp_name"], './'.$_FILES["file"]['name']);

            //Change the users profile picture to this pic
            $users = new users;
            $users->select($_SESSION['userid']);

            $users->change('profile_pic', $_FILES["file"]['name']);

            $users->update();

            //echo
            echo 'Upload success';

        }else{

            //There is already a file by this name
            echo "A file already exists by this name on the server";
        }

    }else{

        //File is to big
        echo 'The file is to big, please upload a file less than 8 mb.';

    }

}

header('location: ./?p=edit_pic');
