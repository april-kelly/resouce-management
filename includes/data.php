<?php

/*
     Name:          Object Oriented MySQLi Interface
     Programmer:    Liam Kelly
     Last Modified: 04/23/13
*/
include_once(ABSPATH.'includes/config/settings.php');

class db
{
	
	//Login related
	private $settings;
	private $db_host;
	private $db_user;
	private $db_database;
	private $user_defined = false;
	
	//mysqli object
	private $dbc;
	
	//Fail
	private $fail = '0';

	//connect to the database
	public function connect()
	{
		//fetch the credentials
		if($this->user_defined == false){

            //Fetch the settings

                //Access Via JSON
			    $this->settings = new settings;
			    $settings = $this->settings->fetch();

			    $this->db_host     = $settings['db_host'];
			    $this->db_user     = $settings['db_user'];
			    $this->db_pass     = $settings['db_pass'];
			    $this->db_database = $settings['db_database'];

                //Direct Access
                /*
                $this->db_host     = '';
                $this->db_user     = '';
                $this->db_pass     = '';
                $this->db_database = '';
                */
		}

            $this->dbc = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_database)
                or die("Could not connect!");


	}
	
	//query the database
	public function query($db_query)
	{
		if($this->fail !== true){
		
			$result = $this->dbc->query($db_query);	//query the database
			
			
			if(is_object($result)){
					
				while($row = $result->fetch_assoc()) {	//fetch assoc array
						$array[] = $row;
				}
				
			}else{
				return false;
			}
			
			if(!(empty($array))){
				return $array;	//return results
			}
			
			return false;

		}
		
	}
	
	//insert into the database
	public function insert($db_query)
	{
		if($this->fail == '0'){

			if(is_object($this->dbc)){
		
				$this->dbc->query($db_query);	//query the database

			}

		}
		
	}

    public function direct($db_query){
        return $this->dbc->query($db_query);
    }

	//delete from the database
	public function delete($db_query)
	{
		if($this->fail == '0'){

			if(is_object($this->dbc)){
		
				$this->dbc->query($db_query);	//query the database

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
		
			return NULL;	//no connection
			
		}
	}
	
	//allow user to sanitize data
	public function sanitize($input)
	{
		
		return $this->dbc->real_escape_string($input);

	}

}

//verify that a peice of data is in the database
function verify($table, $field, $data)
{

	$dbc = new db;			//set up object
	$dbc->connect();		//connect using defaults
	
	//sanitize the user inputs
	$table = $dbc->sanitize($table);
	$field = $dbc->sanitize($field);
	$data  = $dbc->sanitize($data);
	
	$query = "SELECT * FROM ".$table." WHERE `".$field."` = ".$data."";
	
	$result = $dbc->query($query);	//run the query
	$dbc->close();			//close the database connection
	
	if(count($result) == '1'){
		return true;
	}else{
		return false;
	}
		
}
?>