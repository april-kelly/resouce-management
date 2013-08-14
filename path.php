<?php
/**
 * Name:       Defines ABSPATH
 * Programmer: Liam Kelly
 * Date:       6/26/13
 */

define('ABSPATH', dirname(__FILE__).'/');

//Memory debugging *REMOVE BEFORE PRODUCTION*

function sizeofvar($var) {
    $start_memory = memory_get_usage();
    $var = unserialize(serialize($var));
    return memory_get_usage() - $start_memory - PHP_INT_SIZE * 8;
}

