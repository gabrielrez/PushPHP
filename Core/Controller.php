<?php

namespace Core;

use Core\Request;
use Core\Response;

abstract class Controller
{
    /**
     * Retrieves the body of the request.
     *
     * @return array|null Returns the request body as an array, or null if not present.
     */
    protected function getRequestBody(): ?array
    {
        return Request::getRequestBody();
    }

    /**
     * Creates a new Response object, sets the status code, and sends a JSON response.
     *
     * @param array|null $data The data to include in the response body, formatted as JSON (optional).
     * @param int|null $status_code The HTTP status code to set for the response (optional).
     * @return void
     */
    protected function respond(?array $data = null, ?int $status_code = null): void
    {
        if ($status_code !== null && $data !== null) {
            Response::json($data, $status_code);
        }

        return;
    }
}
