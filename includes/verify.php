<?php
/**
 * Name:       Resource Management Recovery
 * Programmer: Liam Kelly
 * Date:       8/29/13
 */

//Start the session
if(!(isset($_SESSION))){
    session_start();
}

//Setup Variables
$fail = false;

echo '<h3>Verification Mode:</h3>';

echo '<span class="info">Verifying the file structure...</span><br /><br />';

//Verify includes
echo '<span class="error">';
if(!(file_exists('../path.php')))                                     { $fail = true; echo 'File ../path.php does not exist!<br />'."\r\n"; }
include_once('../path.php');
if(!(file_exists(ABSPATH.'includes/data.php')))                       { $fail = true; echo 'File ./data.php does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/config/settings.php')))            { $fail = true; echo 'File ./config/settings.php does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/config/settings.json')))           { $fail = true; echo 'File ./config/settings.json does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/config/settings.template')))       { $fail = true; echo 'File ./config/settings.template does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/excel/ABG_PhpToXls.cls.php')))     { $fail = true; echo 'File ./excel/ABG_PhpToXls.cls.php  does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/twofactor/class.googlevoice.php'))){ $fail = true; echo 'File ./twofactor/class.googlevoice.php does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'includes/twofactor/twofactor.php')))        { $fail = true; echo 'File ./twofactor/twofactor.php does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'admin/generate_reset_codes.php')))          { $fail = true; echo 'File ../admin/generate_reset_codes.php does not exist!<br />'."\r\n"; }
if(!(file_exists(ABSPATH.'admin/save.php')))                          { $fail = true; echo 'File ../admin/save.php does not exist!<br />'."\r\n"; }
echo '</span>';

//State Results
if($fail == true){
    echo '<span class="error"><br />Core file(s) missing please reinstall!<br /></span>';
    //exit;
}else{
    echo '<span class="success">File structure is okay.<br /></span>';
}

//Includes
include_once('../path.php');
include_once(ABSPATH.'includes/data.php');
include_once(ABSPATH.'includes/config/settings.php');

//Verifiy Database
$dbc = new db;
$dbc->connect();
$test1 = $dbc->query('select count(*) from jobs');
$test2 = $dbc->query('select count(*) from people');
$test3 = $dbc->query('select count(*) from projects');
$dbc->close();

echo '<span class="info"><br />Verifying the Database...<br /><br /></span>'."\r\n";

if($test1 == false){ $fail = true; echo '<span class="error">Table jobs does not exist or could not connect to db.<br /></span>'."\r\n"; }
    else{ echo '<span class="info">There are '.$test1[0]['count(*)'].' rows in jobs.</span><span class="success"> Looks good.</span><br />'."\r\n"; ; }

if($test2 == false){ $fail = true; echo '<span class="error">Table people does not exist or could not connect to db.<br /></span>'."\r\n"; }
    else{ echo '<span class="info">There are '.$test2[0]['count(*)'].' rows in people.</span><span class="success"> Looks good.</span><br />'."\r\n"; ; }

if($test3 == false){ $fail = true; echo '<span class="error">Table projects does not exist or could not connect to db.<br /></span>'."\r\n"; }
    else{ echo '<span class="info">There are '.$test3[0]['count(*)'].' rows in projects.</span><span class="success"> Looks good.</span><br />'."\r\n"; }

//State Results
if($fail == true){
    echo '<span class="error"><br />Database issues! (please verify database creds and/or reinstall). <br /></span>';
    //exit;
}else{
    echo '<span class="success"><br />Database is okay.<br /></span>';
}

//Verify Settings
$set = new settings;
$settings = $set->fetch();

echo '<span class="info"><br />Verifying settings...<br /><br /></span>';

//Check for Parsbrites (eg haters)
if(!($settings['mlp'] == "\x61\x77\x65\x73\x6F\x6d\x65")){
    echo '<span class="error">Ponies are awesome, now change it back!</span><span class="info"> (settings.php line 16)</span>';
    $fail = true;
}

//State Results
if($fail == true){
    echo '<br /><span class="error"><br />Settings issues!<br /></span>';
    //exit;
}else{
    echo '<span class="success"><br />Settings are okay.<br /></span>';
}

//State Results
if($fail == true){
    //exit;
}else{
    echo '<span class="success"><br />Everything appears to be working...<br /></span>';
}

?>