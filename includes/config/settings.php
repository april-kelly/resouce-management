<?php
/**
 * Name:       Settings creation and fetch class
 * Programmer: liam
 * Date:       5/23/13
 */

class settings {

    //Prefine the settings, with defaults

        //Note: DO NOT use private or protected variables, it will cause json_decode generate a fatal exception.

        //Settings for insert.php
            public $insert_valid    = TRUE;
            public $insert_sanitize = TRUE;
            public $insert_fail     = FALSE;

        //Settings for month.php
            public $month_colors    = FALSE;
            public $month_excel     = TRUE;
            public $month_output    = TRUE;
            public $colors = array();

        //Settings for data.php
            public $db_host         = 'localhost';
            public $db_user         = 'root';
            public $db_pass         = 'kd0hdf';
            public $db_database     = 'resources';

        //Global Settings
            public $weeks           = 12;
            public $location        = NULL; //we'll set this in the constructor
            public $debug           = FALSE;
            public $logo            = './includes/images/logo.gif';
            public $version         = '1.0.1 beta';
            public $salt            = '60b448a4b93f07d724baecc1975b00e4b822efa4f6cb997ae0ec92f9f3580e981fe1d7f56f356d16f1451565fcf39929b0c157206fc9522cdc0caefc7b1945d2';
            public $url             = 'http://localhost/resouce-management/';

    public function __construct(){

        //see if the ABSPATH constant exists
        if(defined(ABSPATH)){

            $this->location = ABSPATH.'includes/config/settings.json'; //location for the settings file

        }else{

            require_once(dirname(dirname(dirname(__FILE__))).'/path.php');
            $this->location = ABSPATH.'includes/config/settings.json'; //location for the settings file

        }

    }

    //Create a json settings file
    public function create()
    {

        $array = (array) $this;

        $json = json_encode($array);

        file_put_contents($this->location, $json);

        return TRUE;

    }

    //Update a json settings file
    public function update($array)
    {

        $json = json_encode($array);

        file_put_contents($this->location, $json);

        return TRUE;

    }

    //Fetch the settings file and return an associative array
    public function fetch()
    {

        $file = file_get_contents($this->location);

        $json = json_decode($file);

        $array = (array) $json;

        return $array;

    }

}