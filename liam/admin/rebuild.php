<?php
/**
 * Name:       settings.bin repair and creation tool
 * Programmer: liam
 * Date:       5/16/13
 */


//settings file location
$location = './settings.bin';

//fetch file
//$file = file_get_contents($location);

//unserialize file
//$settings = unserialize($location);

//spit out debugging information
?>
<h1>Settings.bin debugging information:</h1>
<hr/>
<h3>Serialized:</h3>
<?php
echo '<pre>'.$file.'</pre>';
echo '<h3>Unserialized:</h3>';
echo '<pre>';
var_dump($settings);


$settings['insert_debug']   = FALSE;
$settings['insert_valid']    = TRUE;
$settings['insert_sanitize']    = TRUE;
$settings['insert_fail']    = FALSE;

$settings['month_colors']   = TRUE;
$settings['month_debug']    = FALSE;
$settings['month_excel']    = TRUE;
$settings['month_output']   = TRUE;

$settings['weeks']          = 12;
//$file = serialize($settings);
$file = json_encode($settings);
//file_put_contents($location, $file);


$test = json_decode($file);
var_dump($test);


$array = (array) $test;
var_dump($array);
echo $array['weeks'];


echo '</pre>';