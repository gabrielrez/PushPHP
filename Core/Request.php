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
    public function getBody(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            return $_POST;
        }

        $body = file_get_contents('php://input');
        if ($body) {
            $decoded = json_decode($body, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }
        return null;
    }
}
