<?php
/**
 * Name:       Resource Management Database Creation Tool
 * Programmer: Liam Kelly
 * Date:       7/15/13
 */

if(!(defined('ABSPATH'))){
    require_once('../../path.php');
}
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');


function create_settings_json($user, $host, $pass){

    //Set up the settings
    $set = new settings;
    $set->create();
    $settings = $set->fetch();

    $settings['db_user']     = $user;
    $settings['db_host']     = $host;
    $settings['db_pass']     = $pass;

    $set->update($settings);
}

function create_db($name){

    $dbc = new db;
    $dbc->connect();
    $dbc->direct('CREATE DATABASE '.$name);

    //The people table
    $table_people = 'CREATE TABLE IF NOT EXISTS `people` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` char(128) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `type` int(2) NOT NULL DEFAULT \'0\',
  `admin` int(1) NOT NULL,
  `security_class` tinyint(4) NOT NULL DEFAULT \'0\',
  `colorization` tinyint(1) NOT NULL,
  `reset_code` text NOT NULL,
  `lock_start` date NOT NULL,
  `lock_end` date NOT NULL,
  PRIMARY KEY (`index`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1
    ';

    //The jobs table
    $table_jobs   = 'CREATE TABLE IF NOT EXISTS `'.$name.'`.`jobs` (
      `index` mediumint(9) NOT NULL AUTO_INCREMENT,
      `project_id` varchar(10) NOT NULL,
      `manager` smallint(6) NOT NULL,
      `resource` smallint(6) NOT NULL,
      `requestor` smallint(6) NOT NULL,
      `week_of` date NOT NULL,
      `sunday` time NOT NULL,
      `monday` time NOT NULL,
      `tuesday` time NOT NULL,
      `wednesday` time NOT NULL,
      `thursday` time NOT NULL,
      `friday` time NOT NULL,
      `saturday` time NOT NULL,
      `sales_status` tinyint(1) NOT NULL,
      `priority` tinyint(1) NOT NULL,
      PRIMARY KEY (`index`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1';

    $table_projects = 'CREATE TABLE IF NOT EXISTS `'.$name.'`.`projects` (
    `index` smallint(6) NOT NULL AUTO_INCREMENT,
      `project_id` int(11) NOT NULL,
      `title` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `max_hours` time NOT NULL,
      `assigned_hours` time NOT NULL,
      `overage` tinyint(1) NOT NULL,
      PRIMARY KEY (`index`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1';

    //insert the tables
    $dbc->direct($table_people);
    $dbc->direct($table_jobs);
    $dbc->direct($table_projects);

    //close the connection
    $dbc->close();

    //Set up the settings
    $set = new settings;
    $settings = $set->fetch();

    //save the database name
    $settings['db_database'] = $name;
    $set->update($settings);
}
