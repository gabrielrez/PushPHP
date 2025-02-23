<?php

namespace Core\Http;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, string $action): void
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'GET'
        ];
    }

    public static function post(string $uri, string $action): void
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'POST'
        ];
    }

    public static function put(string $uri, string $action): void
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'PUT'
        ];
    }

    public static function delete(string $uri, string $action): void
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'DELETE'
        ];
    }

    public static function routes(): array
    {
        return self::$routes;
    }

    public static function dispatch(): void
    {
        $url = isset($_SERVER["REQUEST_URI"])
            ? '/' . trim($_SERVER["REQUEST_URI"], '/')
            : '/';

        $route_found = false;

        foreach (self::$routes as $route) {
            if ($route['method'] !== Request::method()) {
                continue;
            }

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

                $controller_instance = new $controller();
                $controller_instance->$action(...$matches);
            }
        }


        if (!$route_found) {
            $controller = 'App\\Controllers\\NotFoundController';
            $controller_instance = new $controller();
            $controller_instance->index();
        }
    }
}
