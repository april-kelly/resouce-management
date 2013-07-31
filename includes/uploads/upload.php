<?php
/**
 * Name:       Resource Management File Uploader
 * Programmer: Liam Kelly
 * Date:       7/31/13
 */

//Includes
require_once('../../path.php');

if(isset($_FILES)){
    var_dump($_FILES);

    if($_FILES["file"]["size"] <= 8388608){

        if(!(file_exists($_FILES["file"]["name"]))){

            //No file exist by this name (yet) so save the upload
            move_uploaded_file($_FILES["file"]["tmp_name"], './'.$_FILES["file"]['name']);

        }else{

            //There is already a file by this name
            echo "A file already exists by this name on the server";
        }

    }else{

        //File is to big
        echo 'The file is to big, please upload a file less than 8 mb.';

    }



}
