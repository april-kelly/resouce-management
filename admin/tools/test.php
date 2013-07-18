<?php

require_once(ABSPATH.'includes/data.php');

echo '<pre>';
$dbc = new db;
$dbc->connect();
$results = $dbc->query('SELECT * FROM people');
$dbc->close();

var_dump($results);
echo '</pre>';