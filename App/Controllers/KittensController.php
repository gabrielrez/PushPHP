<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Kitten;

class KittensController extends Controller
{
    protected $kitten_model;

    public function __construct()
    {
        $this->kitten_model = new Kitten();
    }

    public function index()
    {
        $kittens = $this->kitten_model->all();
        return $this->respond($kittens, 200);
    }

    public function show($id)
    {
        $kitten = $this->kitten_model->findOrFail($id);

        if (!$kitten) {
            return $this->respond(['error' => 'Kitten not found'], 404);
        }

        return $this->respond($kitten, 200);
    }

    public function store()
    {
        $this->kitten_model->save($this->getRequestBody());
        return $this->respond(['success' => 'Kitten created successfully'], 201);
    }

    public function update($id)
    {
        $this->kitten_model->update($id, $this->getRequestBody());
        return $this->respond(['success' => 'Kitten updated successfully'], 200);
    }

    public function destroy($id)
    {
        $kitten = $this->kitten_model->findOrFail($id);

        if (!$kitten) {
            return $this->respond(['error' => 'Kitten not found'], 404);
        }

        $this->kitten_model->delete($id);

        return $this->respond(['success' => 'Kitten deleted successfully'], 200);
    }
}
