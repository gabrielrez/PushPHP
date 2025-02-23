<?php

namespace App\Controllers;

use App\Models\Kitten;
use Core\Http\Request;
use Core\Http\Response;

class KittensController
{
    //Display a listing of all kittens. 🐱
    public function index()
    {
        $kittens = Kitten::all();
        return Response::json($kittens, 200);
    }

    public function show(int $id)
    {
        $kitten = Kitten::find($id);

        if (!$kitten) {
            return Response::json([
                'status' => 404,
                'message' => 'Kitten not found'
            ], 404);
        }

        return Response::json($kitten, 200);
    }

    public function store()
    {
        return Response::json([
            'success' => true,
            'Kitten' => Kitten::create(Request::getRequestBody())
        ], 200);
    }

    public function update(int $id)
    {
        Kitten::update($id, Request::getRequestBody());

        return Response::json([
            'success' => true,
            'message' => 'Kitten updated successfully'
        ], 200);
    }

    public function delete(int $id)
    {
        Kitten::delete($id);

        return Response::json([
            'success' => true,
            'message' => 'Kitten deleted successfully'
        ], 200);
    }
}
