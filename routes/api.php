<?php

use Core\Router;
use Core\Response;

/* ~~~ Application Routes 🚦 ~~~  */

Router::get('/', function () {
    $data = [
        'Push' => 'Wellcome to PushPHP :)',
        'Documentation' => 'https://github.com/gabrielrez/PushPHP'
    ];

    return response(200, $data);
});

// Return all kittens 🐱
Router::get('/kittens', 'KittensController::index',)
    ->ExampleMiddleware();

// Return a specific kitten 🐾
Router::get('/kittens/{id}', 'KittensController::show')
    ->ExampleMiddleware();

// Insert a kitten 🐈
Router::post('/kittens', 'KittensController::store')
    ->ExampleMiddleware();

// Update a kitten 📝
Router::put('/kittens/{id}', 'KittensController::update')
    ->ExampleMiddleware();

// Delete a kitten 🗑️
Router::delete('/kittens/{id}', 'KittensController::destroy')
    ->ExampleMiddleware();
