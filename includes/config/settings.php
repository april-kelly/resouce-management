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
            public $insert_valid    = TRUE;                                     //Make sure all inputs are set
            public $insert_sanitize = TRUE;                                     //Sanitize data before sending to the database
            public $insert_fail     = FALSE;                                    //Fail instead of inserterting

        //Settings for overview.php
            public $month_colors    = FALSE;                                    //Enable output coloration
            public $month_excel     = FALSE;                                    //This will be deprecated
            public $month_output    = TRUE;                                     //Enable output via web and/or csv/excel
            public $colors = array();                                           //Deprecated

        //Settings for data.php
            public $db_host         = 'localhost';                              //MySQL host
            public $db_user         = 'root';                                   //MySQL user
            public $db_pass         = 'kd0hdf';                                 //MySQL password
            public $db_database     = 'resources';                              //MySQL Database

        //Server Settings
            public $domain          = 'serverdomain';
            public $dir             = 'serverdir';
            public $url             = NULL;
            public $maintenance     = FALSE;                                    //Prevents users from accessing during maintenance

        //Basic
            public $logo            = './includes/images/logo.gif';             //Path to the logo in the nav bar
            public $title           = 'Bluetent Marketing Resource Management'; //Title to display

        //Global Settings
            public $weeks           = 12;                                       //Number of weeks to show in all outputs
            public $location        = NULL;                                     //Location of settings.json file (set in constructor)
            public $debug           = FALSE;                                    //Debugging mode
            public $version         = '1.0.3 beta';                             //Version number
            public $production      = FALSE;                                    //Production status of this version beta/normal
            public $production_alert= TRUE;                                     //Alert users if this is a beta release

        //Security
            public $salt            = '60b448a4b93f07d724baecc1975b00e4b822efa4f6cb997ae0ec92f9f3580e981fe1d7f56f356d16f1451565fcf39929b0c157206fc9522cdc0caefc7b1945d2';
            public $salt_changed    = TRUE;                                     //Deprecated

        //Gopher Server (Experimental)
            public $gopher          = FALSE;                                     //Enables/Disables Gopher server
            public $gopher_port     = '70';                                     //Port to run gopher on

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