<?php

/*
 * This file returns the application root folder.
 *
 */

require_once "vendor/autoload.php";

if (!function_exists("app_base_dir")) {
    function app_base_dir()
    {
        return __DIR__;
    }
}


