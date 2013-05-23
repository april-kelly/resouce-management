<?php
/**
 * Name:       Settings creation and fetch class
 * Programmer: liam
 * Date:       5/23/13
 */

class settings {

    /**Prefine the settings, with defaults
     * Note: DO NOT use private or protected variables, it will cause json_decode generate a fatal exception.
    */

        //Settings for insert.php
            public $insert_debug    = FALSE;
            public $insert_valid    = TRUE;
            public $insert_sanitize = TRUE;
            public $insert_fail     = FALSE;

        //Settings for month.php
            public $month_colors    = TRUE;
            public $month_debug     = FALSE;
            public $month_excel     = TRUE;
            public $month_output    = TRUE;

        //Settings for data.php
            public $db_host         = 'localhost';
            public $db_user         = 'root';
            public $db_pass         = 'kd0hdf';
            public $db_database     = 'resources';

        //Global Settings
            public $weeks           = 12;
            public $location        = '/opt/lampp/htdocs/resouce-management/liam/config/settings.json'; //location for the settings file


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