<?php

include_once('../path.php');
include_once(ABSPATH.'admin/user_management.php');

$users = new users;

$status = $users->login('liam@bluetent.com', 'basalt22');

$users->change('admin', '1');
$users->update();

var_dump($status);
//echo $users->name;