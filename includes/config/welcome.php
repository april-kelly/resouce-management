<?php
/**
 * Name:       The initial setup file or Welcome file
 * Programmer: Liam Kelly
 * Date:       6/26/13
 */

//Fetch ABSPATH in the event that this is a new install
if(isset($_REQUEST['submit'])){
    define('ABSPATH', $_REQUEST['ABSPATH']);
}else{
require_once('path.php');
}
//start the session if it does not exist
if(!(isset($_SESSION))){
    session_start();
}

//Includes
require_once(ABSPATH.'includes/config/settings.php');

//Display welcome for first time
if(!(isset($_SESSION['c'])) and !(isset($_REQUEST['submit']))){
?>
<h2>Hello and Welcome,</h2>
<p>It appears that you do not have a settings file! This either means you are just now setting up this program or
something went wrong. If this is a new install please click <a href="?p=config&c=1">here</a> to continue to setup. Otherwise, please click
<a href="?p=config&c=2">here</a> to attempt to rebuild your settings file.</p>
<?php
}else{

    //New install
    if($_SESSION['c'] == '1'){
        ?>
        <form action="./includes/config/welcome.php" method="post">
            <b>Please enter your database credentials:</b><br /><br />
            <input type="text" name="db_host" /><label>Database Hostname</label><br />
            <input type="text" name="db_user" /><label>Database Username</label><br />
            <input type="password" name="db_pass" /><label>Database Password</label><br />
            <input type="text" name="db_database" /><label>Database Name</label><br />
            <input type="hidden" name="ABSPATH" value="<?php echo ABSPATH; ?>" />
            <input type="submit" name="submit" />
        </form>
        <?php
    }

    if(isset($_REQUEST['submit'])){

        $set = new settings;
        $set->location = ABSPATH.'includes/config/settings.json';

        $set->db_database = $_REQUEST['db_database'];
        $set->db_host     = $_REQUEST['db_host'];
        $set->db_pass     = $_REQUEST['db_pass'];
        $set->db_user     = $_REQUEST['db_user'];

        $set->create();
        header('location: ../../?p=home');

    }



//Rebuild
if($_SESSION['c'] == '2'){
    $set = new settings;
    $set->location = ABSPATH.'includes/config/settings.json';
    $set->create();

    session_destroy();
    header('location: ./?p=home');
}


}
?>