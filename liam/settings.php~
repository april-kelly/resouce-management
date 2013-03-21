<?php

/*
	Name: Settings
	Description: Allows the user to change settings for the resource tracker
	Programmer: Liam Kelly
	Last Modified: 02/26/13	
	Comments: This file is currently a stub.
*/

//include the data object
include('data.php');

//settings fetch function
get_settings($id)
{
	
	$dbc = new db;						//set up object
	$dbc->connect();					//connect using defaults
	$id = $dbc->sanitize($id);				//sanitize the inputs
	$query = "SELECT * FROM settings WHERE index='$id'";	//define the query
	$result = $dbc->query($query);				//run the query
	$dbc->close();						//close the database connection
	
	return $results;
	
	
}

//settings creation function
create_settings($name, $settings, $comments){
	
	$dbc = new db;						//set up object
	$dbc->connect();					//connect using defaults
	
	//sanitize the inputs
	$name 	  = $dbc->sanitize($id);
	$settings = $dbc->sanitize($id);
	$comments = $dbc->sanitize($id);
	
	//define the query
	$query = "SELECT * FROM settings WHERE index='$id'";
	
	$result = $dbc->query($query);				//run the query
	$dbc->close();						//close the database connection
	
	return $results;
	
}

?>
