<?php

namespace Core;

/* ~~~ Response Class 🚀 ~~~  */

class Response
{
    protected static int $status_code = 200;
    protected static array $headers = [];
    protected static $body;

    /**
     * Sets the HTTP status code for the response.
     *
     * @param int $statusCode The HTTP status code to set.
     * @return void
     */
    public static function setStatusCode(int $statusCode): void
    {
        self::$status_code = $statusCode;
    }

    /**
     * Adds a header to the response.
     *
     * @param string $header The name of the header.
     * @param string $value The value of the header.
     * @return void
     */
    public static function addHeader(string $header, string $value): void
    {
        self::$headers[$header] = $value;
    }

    /**
     * Sets the body content of the response.
     *
     * @param string $body The content to be included in the response body.
     * @return void
     */
    public static function body(string $body): void
    {
        self::$body = $body;
    }

    /**
     * Sends the response with the current status code, headers, and body content.
     *
     * @return void
     */
    public static function send(): void
    {
        http_response_code(self::$status_code);

        foreach (self::$headers as $header => $value) {
            header("{$header}: {$value}");
        }

        echo self::$body;
    }

    /**
     * Sends a JSON response with the provided status code and data.
     * Sets the Content-Type header to 'application/json' and sends the
     * JSON-encoded data in the response body.
     *
     * @param array $data The data to be returned in JSON format.
     * @param int $status_code The HTTP status code for the response (default is 200).
     * @return void
     */
    public static function json(array $data, int $status_code = 200): void
    {
        self::setStatusCode($status_code);
        self::addHeader('Content-Type', 'application/json');
        self::body(json_encode($data));
        self::send();
    }
}
