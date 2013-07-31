<?php
/**
 * Name:       Resource Management Installer -- Step 3 of 3
 * Programmer: Liam Kelly
 * Date:       7/16/13
 */

//start the users session
if(!(isset($_SESSION))){
session_start();
}

//Includes
require_once('../../path.php');

//Variables
$fail = false;

//Fetch data from step 2
$_SESSION['step2'] = $_REQUEST;

?>

<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="../styles/styles.css" type="text/css" />
    <link rel="icon" href="../images/btm_favicon.ico" />


</head>
<body>

<div id="installer">

    <h1>Step 3: Installation</h1><hr />

    <p>
        Please wait while we install, this should just take a moment....
    </p>

    <?php

        //Ensure the system is not already installed
        //if(!(file_exists('../config/settings.json'))){

            //Create the Settings.php file

                //Define settings to change

                            $settings = file_get_contents('../config/settings.template');


                //Create the salt
                            //Get some random
                            $fp = fopen('/dev/urandom', 'r');

                            //Hash the randomness
                            $salt = hash('SHA512', fread($fp, 512));

                            //What to look for
                            $patterns = array(
                                1 => '/sqlhost/',
                                2 => '/sqluser/',
                                3 => '/sqlpass/',
                                4 => '/sqldb/',
                                5 => '/serverdomain/',
                                6 => '/serversalt/',
                                7 => '/This is a sample for mod.php do not modify \(to edit settings change ..\/config\/settings.php\)/',
                                8 => '/serverdir/',
                            );

                            $replacements = array(
                                1 => $_SESSION['step1']['db_host'],
                                2 => $_SESSION['step1']['db_user'],
                                3 => $_SESSION['step1']['db_pass'],
                                4 => $_SESSION['step1']['db_database'],
                                5 => $_SESSION['step1']['server_domain'],
                                6 => $salt,
                                7 => '',
                                8 => $_SESSION['step1']['server_dir'],
                            );


            $new_settings = preg_replace($patterns, $replacements,  $settings);

                if(!(is_writable(ABSPATH.'includes/config'))){

                    //PHP cannot write the settings.php file
                    ?>
                        <span class="error">Unable to create settings.php file.</span><br />
                        <span class="info">It appears that php does not have enough permission to write/create files. Please fix this or, copy and paste this
                        copy of the configuration file into includes/config/settings.php.</span>
                        <textarea>
                            <?php echo $new_settings; ?>
                        </textarea>
                        <p>
                            <a href="./step3.php?o=">Continue</a>
                        </p>

                    <?php

                    $fail = true;

                    if(isset($_REQUEST['f'])){

                        //Override if necessary
                        $fail = false;

                    }

                }else{

                    //PHP can write the settings.php file
                    file_put_contents(ABSPATH.'includes/config/settings.php', $new_settings);
                    echo '<span class="success">Created settings file.</span><br />';



                }

            if($fail == false){

                //include dependencies which require settings.php
                require_once(ABSPATH.'includes/config/settings.php');
                require_once('./create_db.php');
                require_once('../config/users.php');


                //Create the settings.json file
                $set = new settings;
                $set->create();

                //...and for the database
                create_db($_SESSION['step1']['db_database']);
                echo '<span class="success">Created database.</span><br />';

                //...Finally the user
                $users = new users;

                $users->change('index', null);
                $users->change('name',      $_SESSION['step2']['first_name']);
                $users->change('email',     $_SESSION['step2']['email']);
                $users->change('password',  $_SESSION['step2']['password']);
                $users->change('type',      '2');
                $users->change('admin',     '2');

                $users->create();
                echo '<span class="success">Added user: '.$_SESSION['step2']['first_name'].'.</span><br />';

            }
        echo '<br /><a href="../../?p=home">Continue</a>'


        /*}else{
           ?><span class="error">It appears that you have already installed. Did you mean to preform a <a href="../config/reset.php">repair</a> instead?</span><?php
        }*/
    ?>

</div>

</body>
</html>
