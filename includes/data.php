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

	//change database login info temporarily
	public function credentials($new_host, $new_user, $new_pass, $new_database)
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
		
		$this->user_defined = true;
	
	}
	
	//change the database login info permently
	public function update_creds()
	{
		
		$this->settings['db_host']      = $this->db_host;
		$this->settings['db_user']      = $this->db_user;
		$this->settings['db_pass']      = $this->db_pass;
		$this->settings['db_database']  = $this->db_database;
		
		file_put_contents($this->settings_location, serialize($this->settings));
		
	}
	
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
			
			return;

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
		
		//Working but deprecated
		return $this->dbc->real_escape_string($input);

	}

    /*
    //allow user to verify that a piece of data is in the database
    public function verify($table, $field, $string)
    {

        $data = new db;

        $data->connect();

        //sanitize the user inputs
        $table = $data->sanitize($table);
        $field = $data->sanitize($field);
        $data  = $data->sanitize($string);

        $query = "SELECT * FROM ".$table." WHERE `".$field."` = ".$data."";

        $result = $data->query($query);	//run the query
        $data->close();			//close the database connection

        if(count($result) >= '1'){
            return true;
        }else{
            return false;
        }


        return false;
    }
    */

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