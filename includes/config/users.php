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

    //User Related
    public $index       = '';
    public $firstname   = '';
    public $lastname    = '';
    public $email       = '';
    public $password    = '';
    public $profile_pic = '';
    public $type        = '2';
    public $admin       = '0';
    public $colorization= '0';
    public $reset_code  = '';
    public $lock_start  = '0000-00-00';
    public $lock_end    = '0000-00-00';
    public $phone_number = '';

    //System Related
    public $salt        = '';       //This will be set in the constructor

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
            $this->firstname  = $results[0]['firstname'];
            $this->lastname   = $results[0]['lastname'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->profile_pic= $results[0]['profile_pic'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->colorization= $results[0]['colorization'];
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
            $this->firstname  = $results[0]['firstname'];
            $this->lastname   = $results[0]['lastname'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->profile_pic= $results[0]['profile_pic'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->colorization= $results[0]['colorization'];
            $this->reset_code = $results[0]['reset_code'];
            $this->lock_start = $results[0]['lock_start'];
            $this->lock_end   = $results[0]['lock_end'];

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
        $query = "SELECT * FROM people WHERE `index` = '".$userid."'";
        $results = $dbc->query($query);

        //close connection
        $dbc->close();

        //count the number of rows returned
        if(count($results) == '1'){
            $this->index = $results[0]['index'];

            //Save all of the users information in case they want to issue and update query later
            $this->firstname  = $results[0]['firstname'];
            $this->lastname   = $results[0]['lastname'];
            $this->email      = $results[0]['email'];
            $this->password   = $results[0]['password'];
            $this->profile_pic= $results[0]['profile_pic'];
            $this->type       = $results[0]['type'];
            $this->admin      = $results[0]['admin'];
            $this->colorization= $results[0]['colorization'];
            $this->reset_code = $results[0]['reset_code'];
            $this->lock_start = $results[0]['lock_start'];
            $this->lock_end   = $results[0]['lock_end'];
            $this->phone_number = $results[0]['phone_number'];

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
        $this->firstname  = $dbc->sanitize($this->firstname);
        $this->lastname   = $dbc->sanitize($this->lastname);
        $this->email      = $dbc->sanitize($this->email);
        $this->password   = $dbc->sanitize(hash('SHA512', $this->password.$this->salt));
        $this->profile_pic= $dbc->sanitize($this->profile_pic);
        $this->type       = $dbc->sanitize($this->type);
        $this->admin      = $dbc->sanitize($this->admin);
        $this->colorization= $dbc->sanitize($this->colorization);
        $this->reset_code = $dbc->sanitize($this->reset_code);
        $this->lock_start = $dbc->sanitize($this->lock_start);
        $this->lock_end   = $dbc->sanitize($this->lock_end);
        $this->phone_number = $dbc->sanitize($this->phone_number);

        //define query
        $query = "INSERT INTO `people` (`index`, `firstname`, `lastname`, `email`, `phone_number`, `password`, `profile_pic`, `type`, `admin`, `colorization`, `reset_code`, `lock_start`, `lock_end`)
                VALUES (NULL,
                 '".$this->firstname."',
                 '".$this->lastname."',
                 '".$this->email."',
                 '".$this->phone_number."',
                 '".$this->password."',
                 '".$this->profile_pic."',
                 '".$this->type."',
                 '".$this->admin."',
                 '".$this->colorization."',
                 '".$this->reset_code."',
                 '".$this->lock_start."',
                 '".$this->lock_end."'
                 )";

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
        $this->firstname  = $dbc->sanitize($this->firstname);
        $this->lastname   = $dbc->sanitize($this->lastname);
        $this->email      = $dbc->sanitize($this->email);
        $this->password   = $dbc->sanitize($this->password); //password MUST already be hashed with SHA512
        $this->profile_pic= $dbc->sanitize($this->profile_pic);
        $this->type       = $dbc->sanitize($this->type);
        $this->admin      = $dbc->sanitize($this->admin);
        $this->colorization= $dbc->sanitize($this->colorization);
        $this->reset_code = $dbc->sanitize($this->reset_code);
        $this->lock_start = $dbc->sanitize($this->lock_start);
        $this->lock_end   = $dbc->sanitize($this->lock_end);
        $this->phone_number = $dbc->sanitize($this->phone_number);


        //define query
        $query = "UPDATE `people` SET
                `firstname`    = '".$this->firstname."',
                `lastname`     = '".$this->lastname."',
                `email`        = '".$this->email."',
                `phone_number` = '".$this->phone_number."',
                `password`     = '".$this->password."',
                `profile_pic`  = '".$this->profile_pic."',
                `type`         = '".$this->type."',
                `admin`        = '".$this->admin."',
                `colorization` = '".$this->colorization."',
                `reset_code`   = '".$this->reset_code."',
                `lock_start`   = '".$this->lock_start."',
                `lock_end`     = '".$this->lock_end."'
                 WHERE `index` = '".$this->index."'";

        //run the query
        var_dump($query);
        $dbc->insert($query);

        //close connection
        $dbc->close();

    }



}