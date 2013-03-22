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
	function fetch($id){
		
		$dbc = new db;						//set up object
		$dbc->connect();					//connect using defaults
		$id = $dbc->sanitize($id);				//sanitize the inputs
		$query = "SELECT * FROM settings WHERE id='$id'";	//define the query
		$results = $dbc->query($query);				//run the query
		$dbc->close();						//close the database connection
	
		return $results;
	
	
	}

	//settings creation function
	function create($name, $value, $comments){
	
		$dbc = new db;						//set up object
		$dbc->connect();					//connect using defaults
	
		//sanitize the inputs
		$name 	  = $dbc->sanitize($name);
		$value = $dbc->sanitize($value);
		$comments = $dbc->sanitize($comments);
	
		//define the query
		$query = "INSERT INTO `resources`.`settings` (`id`, `name`, `value`, `comments`) VALUES (NULL, \'".$name."\', \'".$value."\', \'".$comments."\')";
		
		$result = $dbc->insert($query);				//run the query
		$dbc->close();						//close the database connection
	
		return $result;
	
	}


//Colors
/*$colors = array(array('color' => 'green', 'low' => '1', 'high' => '15'),
		array('color' => 'yellow', 'low' => '16', 'high' => '30'),
		array('color' => 'orange', 'low' => '31', 'high' => '39'),
		array('color' => 'red', 'low' => '40', 'high' => ''),
		);*/

//$set = create('colors', serialize($colors), 'Color coding settings for month.php');

?>
