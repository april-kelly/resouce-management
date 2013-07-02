<?php
/**
 * Name:       Shows the system status
 * Programmer: Liam Kelly
 * Date:       7/2/13
 */

//includes
require_once(ABSPATH.'includes/config/settings.php');

//fetch the settings
$set = new settings;
$settings = $set->fetch();



?>
<p>
Hello and welecome to version <?php echo $settings['version']; ?> of the Bluetent Resource Management software.
</p>