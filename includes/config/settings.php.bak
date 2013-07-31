<?php
/**
 * Name:       Settings creation and fetch class
 * Notes:      
 * Programmer: Liam Kelly
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
            public $db_user         = 'root';                              //MySQL user
            public $db_pass         = 'kd0hdf';                              //MySQL password
            public $db_database     = 'resources';                                //MySQL Database

        //Server Settings
            public $domain          = 'localhost';
            public $dir             = '/resource-management/';
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
            public $salt            = 'cfc8f21aa94415bdca4c7422b006cb689c37332ee3013519a54b62f8f786ebbf9ce08ba8162cedb7be5fe46f2a12731ba0d44e892daddc2d409694907f20976f';
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

        //Define $url
        $this->url = $this->domain.$this->dir;

    }

    //Create a json settings file
    public function create()
    {

        $array = (array) $this;

        //Throw away database creds
        unset($array['db_host']);
        unset($array['db_user']);
        unset($array['db_pass']);
        unset($array['db_database']);

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

        //Fetch the json
        $file = file_get_contents($this->location);

        //Decode it
        $json = json_decode($file);

        //Create an array
        $array = (array) $json;

        //Add in the database creds
        $array['db_host'] = $this->db_host;
        $array['db_user'] = $this->db_user;
        $array['db_pass'] = $this->db_pass;
        $array['db_database'] = $this->db_database;

        return $array;

    }

}
