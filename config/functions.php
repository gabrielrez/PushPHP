<?php

/* ~~~ Helper Functions 🔧 ~~~  */

use Core\Request;
use Core\Response;

/**
 * Displays the content of a variable.
 * 
 * @param mixed $something The content to be displayed.
 * @return void
 */
function push(mixed $something): void
{
    echo $something;
}

/**
 * Dumps and displays the content of variables, then terminates the script.
 * 
 * @param mixed ...$somethings The variables to be displayed.
 * @return void
 */
function dd(mixed ...$somethings): void
{
    foreach ($somethings as $something) {
        push("<pre>");
        var_dump($something);
    }
    die;
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
function respond(array $data, int $status_code = 200): void
{
    Response::json($data, $status_code);
    return;
}

/**
 * Gets the body of the request decoded as an array.
 *
 * @return array|null The body of the request in array format, or null if the decoding fails.
 */
function getRequestBody(): array|null
{
    return Request::getRequestBody();
}

function get_status_code(): int|bool
{
    return http_response_code();
}
