<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Http\Response;

class NotFoundController
{
    public function index()
    {
        return Response::json([
            'message' => '404 Not Found'
        ], 404);
    }
}
