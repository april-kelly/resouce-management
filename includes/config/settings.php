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
            public $version         = '1.0.0 beta';
            public $salt            = 'cb317a4b863ecc5fc80a33e286671b3c317fafbee77e5ac1099fe45c0d06d95595e63df5f4a48d2fa8535e513817b175588bf62bbca4331a1d01b9cac088ae40';

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