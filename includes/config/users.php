<?php
/**
 * Name:       Functions for user management
 * Programmer: Liam Kelly
 * Date:       6/21/13
 */

//includes
require_once(ABSPATH.'includes/data.php');
require_once(ABSPATH.'includes/config/settings.php');

class users {

    public $index       = '';
    public $name        = '';
    public $email       = '';
    public $password    = '';
    public $type        = '2';
    public $admin       = '0';
    public $reset_code  = '';
    public $salt        = '';       //This will be set in the construtor

    //Constructor
    function __construct(){

        $set = new settings;
        $settings = $set->fetch();
        $this->salt = $settings['salt'];

    }

    public function reset_code($code){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $code = $dbc->sanitize($code);

        //search for user
        $query = "SELECT * FROM people WHERE reset_code='".$code."' ";
        $results = $dbc->query($query);

        //close connection
        $dbc->close();

        //count the number of rows returned
        if(count($results) == '1'){
            $this->index = $results[0]['index'];

            //Save all of the users information in case they want to issue and update query later
            $this->name       = $results[0]['name'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->reset_code = $results[0]['reset_code'];

            return $results;
        }else{
            return false;
        }


    }

    //Checks a supplied username and password in the database
    public function login($username, $password){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $username = $dbc->sanitize($username);
        $password = hash('SHA512', $password.$this->salt);

        //search for user
        $query = "SELECT * FROM people WHERE email='".$username."' AND password='".$password."'";
        $results = $dbc->query($query);

        //close connection
        $dbc->close();

        //count the number of rows returned
        if(count($results) == '1'){
            $this->index = $results[0]['index'];

            //Save all of the users information in case they want to issue and update query later
            $this->name       = $results[0]['name'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->reset_code = $results[0]['reset_code'];

            return $results;
        }else{
            return false;
        }

    }

    //Deletes an existing user
    public function delete(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //search for user
        $query = "SELECT * FROM people WHERE index='".$this->index."'";
        $results = $dbc->query($query);

        if(count($results) == '1'){

           //go ahead with the delete query
           $query = "DELETE FROM people WHERE `index`='".$this->index."'";
           $dbc->delete($query);

           return true;

        }else{

           return false;

        }

        //close connection
        $dbc->close();


    }


    //Selects a user in the database
    public function select($userid){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize user inputs
        $userid = $dbc->sanitize($userid);


        //search for user
        $query = "SELECT * FROM people WHERE index = '".$userid."'";
        $results = $dbc->query($query);

        //close connection
        $dbc->close();

        //count the number of rows returned
        if(count($results) == '1'){
            $this->index = $results[0]['index'];

            //Save all of the users information in case they want to issue and update query later
            $this->name       = $results[0]['name'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->reset_code = $results[0]['reset_code'];

            return $results;
        }else{
            return false;
        }

    }

    //Create a new user (set values with define())
    public function create(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize inputs
        $this->name       = $dbc->sanitize($this->name);
        $this->email      = $dbc->sanitize($this->email);
        $this->password   = $dbc->sanitize(hash('SHA512', $this->password.$this->salt));
        $this->type       = $dbc->sanitize($this->type);
        $this->admin      = $dbc->sanitize($this->admin);
        $this->reset_code = $dbc->sanitize($this->reset_code);

        //define query
        $query = "INSERT INTO people (`index`, `name`, `email`, `password`, `type`, `admin`)
                VALUES (NULL,
                 '".$this->name."',
                 '".$this->email."',
                 '".$this->password."',
                 '".$this->type."',
                 '".$this->admin."',
                 '".$this->reset_code."')";

        //run the query
        $dbc->insert($query);

        //close connection
        $dbc->close();

    }

    //This function allows the user to change the values in $this with out accessing them directly
    public function change($key, $value){

        if(isset($this->$key)){
            $this->$key = $value;
            return true;
        }else{
            return false;
        }

    }

    //Updates an existing user's information, credentials, etc.
    public function update(){

        //connect to the database
        $dbc = new db;
        $dbc->connect();

        //sanitize inputs
        $this->name       = $dbc->sanitize($this->name);
        $this->email      = $dbc->sanitize($this->email);
        $this->password   = $dbc->sanitize($this->password); //password MUST already be hashed with sha1
        $this->type       = $dbc->sanitize($this->type);
        $this->admin      = $dbc->sanitize($this->admin);
        $this->reset_code = $dbc->sanitize($this->reset_code);


        //define query
        $query = "UPDATE people SET
                `name`         = '".$this->name."',
                `email`        = '".$this->email."',
                `password`     = '".$this->password."',
                `type`         = '".$this->type."',
                `admin`        = '".$this->admin."',
                `reset_code`   = '".$this->reset_code."'
                 WHERE `index` = '".$this->index."'";

        //run the query
        echo $query;
        $dbc->insert($query);

        //close connection
        $dbc->close();

    }



}