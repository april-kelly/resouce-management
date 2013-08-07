<?php
/**
 * Name:       Settings creation and fetch class
 * Notes:      
 * Programmer: Liam Kelly
 * Date:       5/23/13
 */

class settings {

    //Predefine the settings, with defaults

        //Note: DO NOT use private or protected variables, it will cause json_decode generate a fatal exception.

        //Global Settings
            public $mlp             = 'awesome';                                //Deal with it.
            public $weeks           = 12;                                       //Number of weeks to show in all outputs
            public $location        = NULL;                                     //Location of settings.json file (set in constructor)
            public $debug           = FALSE;                                    //Debugging mode
            public $version         = '1.0.4';                                  //Version number
            public $production      = TRUE;                                    //Production status of this version beta/normal
            public $production_alert= TRUE;                                     //Alert users if this is a beta release
            public $platform        = 'Linux';                               //Server os

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

        //Security
            public $salt            = '613c0873b8430f6a4440464361f1ee696d2448d4b02f58096642bfc1f01c7646bbb01f8c7c2a7a0b9b403f848d35fcea47550d1cfdff22d12478f5c915b47fc3';
            public $salt_changed    = TRUE;                                      //Deprecated

        //Gopher Server (Experimental)
            public $gopher          = FALSE;                                     //Enables/Disables Gopher server
            public $gopher_port     = '70';                                      //Port to run gopher on

        //User Created Settings
            /*telomerase*/



    public function __construct(){

        //see if the ABSPATH constant exists
        if(defined(ABSPATH)){

            $this->location = ABSPATH.'includes/config/settings.json'; //location for the settings file

        }else{

            require_once(dirname(dirname(dirname(__FILE__))).'/path.php');
            $this->location = ABSPATH.'includes/config/settings.json'; //location for the settings file

        }

        //Define $url
        $this->url = 'http://'.$this->domain.$this->dir;

    }

    //Create a json settings file
    public function create()
    {

        $array = (array) $this;

        //Throw away database creds and the salt
        unset($array['db_host']);
        unset($array['db_user']);
        unset($array['db_pass']);
        unset($array['db_database']);
        unset($array['salt']);

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

        //Add in the database creds and the salt
        $array['db_host'] = $this->db_host;
        $array['db_user'] = $this->db_user;
        $array['db_pass'] = $this->db_pass;
        $array['db_database'] = $this->db_database;
        $array['salt'] = $this->salt;

        return $array;

    }

    //Creates new settings
    public function add($key, $value, $comment){

        $self = file_get_contents(ABSPATH.'includes/config/settings.php');

        $new = 'public $'.$key.' = \''.$value.'\'; //'.$comment."\r\n".'            '.base64_decode('Lyp0ZWxvbWVyYXNlKi8=');
        $self = preg_replace('/\/\*telomerase\*\//', $new, $self);

        file_put_contents(ABSPATH.'includes/config/settings.php', $self);

    }

    //Rebuild the settings.php file
    public function rebuild($rebuild){

        $settings = file_get_contents(ABSPATH.'includes/config/settings.template');

        //Create the salt

        //Check for the platform
        if(php_uname('s') == 'Linux'){

            //Okay, were running on linux so, use /dev/urandom
            //This is more secure (f.y.i)

            //Get some random
            $fp = fopen('/dev/urandom', 'r');

            //Hash the randomness
            $salt = hash('SHA512', fread($fp, 512));

        }else{

            //Were not on linux so, well use the less secure mt_rand() function
            $salt = hash('SHA512', mt_rand());

        }

        //What to look for
        $patterns = array(
            1 => '/sqlhost/',
            2 => '/sqluser/',
            3 => '/sqlpass/',
            4 => '/sqldb/',
            5 => '/serverdomain/',
            6 => '/serversalt/',
            7 => '/This is a sample for the installer, do not modify \(to edit settings change ..\/config\/settings.php\)/',
            8 => '/serverdir/',
            9 => '/serveros/',
        );

        $replacements = array(
            1 => $rebuild['db_host'],
            2 => $rebuild['db_user'],
            3 => $rebuild['db_pass'],
            4 => $rebuild['db_database'],
            5 => $rebuild['server_domain'],
            6 => $salt,
            7 => '',
            8 => $rebuild['server_dir'],
            9 => php_uname('s'),
        );


        $new_settings = preg_replace($patterns, $replacements,  $settings);
        echo $new_settings;
        //Write the new settings
        //file_put_contents(ABSPATH.'includes/config/settings.php', $new_settings);

    }


}
