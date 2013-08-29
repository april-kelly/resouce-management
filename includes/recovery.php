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

echo "Verifying the file structure...<br /><br />";

//Verify includes
if(!(file_exists('../path.php')))                      { $fail = true; echo 'File ../path.php does not exist!<br />'."\r\n"; }
if(!(file_exists('./data.php')))                       { $fail = true; echo 'File ./data.php does not exist!<br />'."\r\n"; }
if(!(file_exists('./config/settings.php')))            { $fail = true; echo 'File ./config/settings.php does not exist!<br />'."\r\n"; }
if(!(file_exists('./config/settings.json')))           { $fail = true; echo 'File ./config/settings.json does not exist!<br />'."\r\n"; }
if(!(file_exists('./config/settings.template')))       { $fail = true; echo 'File ./config/settings.template does not exist!<br />'."\r\n"; }
if(!(file_exists('./excel/ABG_PhpToXls.cls.php')))     { $fail = true; echo 'File ./excel/ABG_PhpToXls.cls.php  does not exist!<br />'."\r\n"; }
if(!(file_exists('./twofactor/class.googlevoice.php'))){ $fail = true; echo 'File ./twofactor/class.googlevoice.php does not exist!<br />'."\r\n"; }
if(!(file_exists('./twofactor/twofactor.php')))        { $fail = true; echo 'File ./twofactor/twofactor.php does not exist!<br />'."\r\n"; }
if(!(file_exists('../admin/generate_reset_codes.php'))){ $fail = true; echo 'File ../admin/generate_reset_codes.php does not exist!<br />'."\r\n"; }
if(!(file_exists('../admin/save.php')))                { $fail = true; echo 'File ../admin/save.php does not exist!<br />'."\r\n"; }

//State Results
if($fail == true){
    echo '<span class="error"><br />Core file(s) missing please reinstall!<br /></span>';
    exit;
}else{
    echo '<span class="success">File structure is okay.<br /></span>';
}

//Includes
include_once('../path.php');
include_once(ABSPATH.'includes/data.php');

//Verifiy Database
$dbc = new db;
$dbc->connect();
$test1 = $dbc->query('select count(*) from jobs');
$test2 = $dbc->query('select count(*) from people');
$test3 = $dbc->query('select count(*) from projects');
$dbc->close();

echo '<br />Verifying the Database...<br /><br />'."\r\n";

if($test1 == false){ $fail = true; echo 'Table jobs does not exist or could not connect to db.<br />'."\r\n"; }
    else{ echo 'There are '.$test1[0]['count(*)'].' rows in jobs. Looks good.<br />'."\r\n"; ; }

if($test2 == false){ $fail = true; echo 'Table people does not exist or could not connect to db.<br />'."\r\n"; }
    else{ echo 'There are '.$test2[0]['count(*)'].' rows in people. Looks good.<br />'."\r\n"; ; }

if($test3 == false){ $fail = true; echo 'Table projects does not exist or could not connect to db.<br />'."\r\n"; }
    else{ echo 'There are '.$test3[0]['count(*)'].' rows in projects. Looks good.<br />'."\r\n"; }

//State Results
if($fail == true){
    echo '<span class="error"><br />Database issues!<br /></span>';
    exit;
}else{
    echo '<span class="success"><br />Database is okay.<br /></span>';
}



?>