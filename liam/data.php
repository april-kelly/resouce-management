<?php

/*
	Object Oriented MySQLi Interface
	By: Liam Kelly
	12/05/12
*/

class db
{
	//hard coded database login info
	private $db_host = 'localhost';
	private $db_user = 'root';
	private $db_pass = 'kd0hdf';
	private $db_database = 'resources';
	
	//mysqli object
	private $dbc;
	
	//Fail
	private $fail = '0';

	//change database login info
	public function set ($new_host, $new_user, $new_pass, $new_database)
	{
	
		if(isset($new_host)){
			$this->db_host = $new_host;
		}
		
		if(isset($new_user)){
			$this->db_user = $new_user;
		}
		
		if(isset($new_pass)){
			$this->db_pass = $new_pass;
		}
		
		if(isset($new_host)){
			$this->db_database = $new_database;
		}
	
	}
	
	//connect to the database
	public function connect()
	{
	
		$this->dbc = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database) or die($this->fail = '1');
		
	}
	
	//query the database
	public function query($db_query)
	{
		if($this->fail !== true){
		
			$result = $this->dbc->query($db_query);	//query the database
			
			while ($row = $result->fetch_assoc()) {	//fetch assoc array
				$array[] = $row;
			}
			
			return $array;	//return results
			

		}
		
	}
	
	//inset into the database
	public function insert($db_query)
	{
		if($this->fail == '0'){

			if(is_object($this->dbc)){
		
				$this->dbc->query($db_query);	//query the database
				/*
				while ($row = $result->fetch_assoc()) {	//fetch assoc array
					$array[] = $row;
				}
			
				return $array;	//return results*/
			}

		}
		
	}
	
	//disconnect from the database
	public function close()
	{
		if($this->fail == '0'){
		
			if($this->dbc->close())
			{
			
				return true;	//connection closed
				
			}
			else
			{
		
				return false;	//connection not closed
				
			}
			
		}
		else
		{
		
			return false;	//no connection
			
		}
	}
	
	//allow user to sanatize data
	public function sanitize($input)
	{
		
		return $this->dbc->real_escape_string($input);
		
	}
	
}

//Quick access functions

//Provide a quick query function that uses preset defaults
function query($query)
{	
	
	$dbc = new db;			//set up object
	$dbc->connect();		//connect using defaults
	$result = $dbc->query($query);	//run the query
	$dbc->close();			//close the database connection
	
	return $result;			//return the results
	
}

//verify that a peice of data is in the database
function verify($table, $field, $data)
{
	
	$query = "SELECT * FROM ".$table." WHERE `".$field."` = ".$data."";

	$dbc = new db;			//set up object
	$dbc->connect();		//connect using defaults
	$result = $dbc->query($query);	//run the query
	$dbc->close();			//close the database connection
	
	if(count($result) == '1'){
		return true;
	}else{
		return false;
	}
		
}

