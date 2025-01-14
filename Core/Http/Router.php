<?php

namespace Core\Http;

class Router
{
    private static array $routes = [];

    public static function get(string $uri, string $action)
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'GET'
        ];
    }

    public static function post(string $uri, string $action)
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'POST'
        ];
    }

    public static function put(string $uri, string $action)
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'PUT'
        ];
    }

    public static function delete(string $uri, string $action)
    {
        self::$routes[] = [
            'uri' => $uri,
            'action' => $action,
            'method' => 'DELETE'
        ];
    }

    public static function routes()
    {
        return self::$routes;
    }
}
