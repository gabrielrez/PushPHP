<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Kitten;
use App\Services\KittenService;
use Core\Http\Request;
use Core\Http\Response;

class KittensController
{
    public function index(Request $request, Response $response)
    {
        // All kittens
        $response::json([
            'message' => 'Hello World!'
        ], 200);
    }

    public function show(Request $request, Response $response, int $id)
    {
        // A especific kitten
    }

    public function store(Request $request, Response $response)
    {
        // Create a new kitten
    }

    public function update(Request $request, Response $response)
    {
        // Update a kitten
    }

    public function destroy(Request $request, Response $response, int $id)
    {
        // Delete a kitten
    }
}
