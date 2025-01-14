<?php

namespace Core;

use Core\Http\Router;
use Core\Http\Request;
use Core\Http\Response;

/* ~~~ Initialization Class 🌱 ~~~  */

class Push
{
    /**
     * Initializes the application by setting up the environment, including 
     * PHP version checks, loading configuration files, and setting headers.
     */
    public static function start()
    {
        if (PHP_VERSION < '8.0.0') {
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

        self::dispatch(Router::routes());
    }

    public static function dispatch(array $routes)
    {
        $url = isset($_SERVER["REQUEST_URI"])
            ? '/' . trim($_SERVER["REQUEST_URI"], '/')
            : '/';

        $route_found = false;

        foreach ($routes as $route) {
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['uri']) . '$#';

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);

                $route_found = true;

                if ($route['method'] !== Request::method()) {
                    Response::json([
                        'error' => true,
                        'success' => false,
                        'message' => 'Method not allowed.'
                    ], 405);

                    return;
                }

                [$controller, $action] = explode('::', $route['action']);

                $controller = 'App\\Controllers\\' . $controller;

                $extend_controller = new $controller();
                $extend_controller->$action(new Request, new Response, $matches);
            }
        }

        if (!$route_found) {
            $controller = 'App\\Controllers\\NotFoundController';
            $extend_controller = new $controller();
            $extend_controller->index(new Request, new Response);
        }
    }
}
