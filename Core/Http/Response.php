<?php

namespace Core\Http;

class Response
{
    /**
     * Send a JSON response
     *
     * @param array $data
     * @param int $status_code
     */
    public static function json(array $data = [], int $status_code = 200)
    {
        http_response_code($status_code);
        header("Content-Type: application/json");

        echo json_encode($data);
    }

    /**
     * Send an HTML response
     *
     * @param string $content
     * @param int $status_code
     */
    public static function html(string $content, int $status_code = 200)
    {
        http_response_code($status_code);
        header("Content-Type: text/html");

        echo $content;
    }

    /**
     * Send a plain text response
     *
     * @param string $content
     * @param int $status_code
     */
    public static function text(string $content, int $status_code = 200)
    {
        http_response_code($status_code);
        header("Content-Type: text/plain");

        echo $content;
    }
}
