<?php

namespace Core;

/* ~~~ Request Class 📩 ~~~  */

class Request
{
    /**
     * Gets the body of the request decoded as an array.
     *
     * @return array|null The body of the request in array format, or null if the decoding fails.
     */
    public static function getRequestBody(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            return $_POST;
        }

        $body = file_get_contents('php://input');

        if (!$body) {
            return null;
        }

        $decoded_body = json_decode($body, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            return null;
        }

        return $decoded_body;
    }
}
