<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Kitten;
use App\Services\KittenService;
use Core\Http\Request;
use Core\Http\Response;
use Core\Utilities\Validator;

class KittensController
{
    //Display a listing of all kittens. 🐱
    public function index(Request $request, Response $response)
    {
        $response::json(Kitten::all(), 200);
    }

    // Display a specific kitten by its ID. 🔍
    public function show(Request $request, Response $response, int $id)
    {
        $response::json(Kitten::findOrFail($id), 200);
    }

    // Store a newly created kitten in the database. 🐾
    public function store(Request $request, Response $response)
    {
        $kitten_id = Kitten::create(Validator::validate($request::getRequestBody()));

        $response::json([
            'success' => true,
            'message' => 'Kitten created succesfully. 🎉',
            'kitten' => Kitten::find($kitten_id)
        ], 201);
    }

    // Update the specified kitten in the database. ✏️
    public function update(Request $request, Response $response, int $id)
    {
        Kitten::update($id, $request::getRequestBody());

        $response::json([
            'success' => true,
            'message' => 'Kitten updated succesfully. 🔄',
            'kitten' => Kitten::find($id)
        ], 200);
    }

    // Delete the specified kitten from the database. ❌
    public function destroy(Request $request, Response $response, int $id)
    {
        Kitten::delete($id);

        $response::json([
            'success' => true,
            'message' => 'Kitten deleted succesfully. 🗑️'
        ]);
    }
}
