<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Kitten;

class KittensController extends Controller
{
    /**
     * @var Kitten $kitten_model Instance of the Kitten model.
     */
    protected Kitten $kitten_model;

    /**
     * Constructor.
     * Initializes the Kitten model.
     */
    public function __construct()
    {
        $this->kitten_model = new Kitten();
    }

    /**
     * Retrieves all kittens.
     *
     * @return void
     */
    public function index()
    {
        $kittens = $this->kitten_model->all();
        return $this->respond($kittens, 200);
    }

    /**
     * Retrieves a specific kitten by ID.
     *
     * @param int $id The ID of the kitten.
     * @return void
     */
    public function show(int $id)
    {
        $kitten = $this->kitten_model->findOrFail($id);

        if (!$kitten) {
            return $this->respond(['error' => 'Kitten not found'], 404);
        }

        return $this->respond($kitten, 200);
    }

    /**
     * Stores a new kitten.
     *
     * @return void
     */
    public function store()
    {
        $this->kitten_model->save($this->getRequestBody());
        return $this->respond(['success' => 'Kitten created successfully'], 201);
    }

    /**
     * Updates an existing kitten by ID.
     *
     * @param int $id The ID of the kitten to update.
     * @return void
     */
    public function update(int $id)
    {
        $this->kitten_model->update($id, $this->getRequestBody());
        return $this->respond(['success' => 'Kitten updated successfully'], 200);
    }


    /**
     * Deletes a kitten by ID.
     *
     * @param int $id The ID of the kitten to delete.
     * @return void
     */
    public function destroy(int $id)
    {
        $kitten = $this->kitten_model->findOrFail($id);

        if (!$kitten) {
            return $this->respond(['error' => 'Kitten not found'], 404);
        }

        $this->kitten_model->delete($id);

        return $this->respond(['success' => 'Kitten deleted successfully'], 200);
    }
}
