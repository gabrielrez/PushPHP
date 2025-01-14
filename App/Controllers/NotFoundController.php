<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class NotFoundController
{
    public function index(Request $request, Response $response)
    {
        $response::json([
            'error' => true,
            'success' => false,
            'message' => '404 Not Found'
        ], 404);

        return;
    }
}
