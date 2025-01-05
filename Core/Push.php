<?php

namespace Core;

/* ~~~ Initialization Class 🌱 ~~~  */

class Push
{
    /**
     * Initializes the application by setting up the environment, including 
     * PHP version checks, loading configuration files, and setting headers.
     *
     * @throws Exception If the PHP version is less than 8.0.0.
     */
    public static function start(){
        if(PHP_VERSION < '8.0.0'){
            die('You need to use PHP version 8.0.0 or higher');
        }
        
        require_once __DIR__ . '/../config/constants.php';

        date_default_timezone_set(TIMEZONE);

        require_once ROOT_PATH . '/config/functions.php';
        require_once ROOT_PATH . 'vendor/autoload.php';
        require_once ROOT_PATH . 'routes/api.php';

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        Router::run();
    }
}
