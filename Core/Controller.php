<?php

namespace Core;

use Core\Request;
use Core\Response;

abstract class Controller
{
     /**
     * Retrieves the body of the request.
     *
     * This method creates a new instance of the Request class
     * and calls the getBody() method, which presumably returns
     * the request payload as an associative array.
     * 
     * @return array|null Returns the request body as an array, or null if not present.
     */
    protected function getRequestBody(): ?array
    {
        return (new Request())
            ->getBody();
    }

    /**
     * Creates a new Response object, sets the status code, and sends a JSON response.
     *
     * If both a status code and data are provided, the response is formatted as JSON
     * with the specified status code and data, and then sent to the client.
     *
     * @param int|null $statusCode The HTTP status code to set for the response (optional).
     * @param array|null $data The data to include in the response body, formatted as JSON (optional).
     * @return Response Returns the Response object, whether it was sent or not.
     */
    protected function response(?int $statusCode = null, ?array $data = null): Response
    {
        $response = new Response();

        if ($statusCode !== null && $data !== null) {
            $response->setStatusCode($statusCode)
                ->json($data)
                ->send();
        }

        return $response;
    }
}
