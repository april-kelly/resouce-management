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

function create_settings($user, $host, $pass, $name){

    $set = new settings;
    $set->create();
    $settings = $set->fetch();

    $settings['db_user']     = $user;
    $settings['db_host']     = $host;
    $settings['db_pass']     = $pass;
    $settings['db_database'] = $name;

    $set->update($settings);

}

function create_db($name){

    $dbc = new db;
    //$dbc->credentials($user, $host, $pass, $name);
    //$dbc->update_creds();
    $dbc->connect();
    $dbc->direct('CREATE DATABASE '.$name);

    //The people table
    $table_people = 'CREATE TABLE IF NOT EXISTS `'.$name.'`.`people` (
      `index` int(11) NOT NULL AUTO_INCREMENT,
      `name` text NOT NULL,
      `email` text NOT NULL,
      `password` text NOT NULL,
      `type` int(11) NOT NULL DEFAULT \'0\',
      `admin` int(1) NOT NULL,
      `reset_code` text NOT NULL,
      PRIMARY KEY (`index`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0
    ';

    //The jobs table
    $table_jobs   = 'CREATE TABLE IF NOT EXISTS `'.$name.'`.`jobs` (
      `index` int(11) NOT NULL AUTO_INCREMENT,
      `project_id` int(11) NOT NULL,
      `manager` int(11) NOT NULL,
      `resource` int(11) NOT NULL,
      `requestor` int(11) NOT NULL,
      `week_of` date NOT NULL,
      `time` blob NOT NULL,
      `sales_status` tinyint(1) NOT NULL,
      `priority` int(2) NOT NULL,
      PRIMARY KEY (`index`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0';

    //insert the tables
    $dbc->direct($table_people);
    $dbc->direct($table_jobs);
    //*/
    //close the connection
    $dbc->close();

}
