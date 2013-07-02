<?php

require_once(ABSPATH.'includes/data.php');

$dbc = new db;
$dbc->connect();
$results = $dbc->query('SELECT * FROM people');
$dbc->close();

var_dump($results);