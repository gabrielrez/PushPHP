<?php

use Core\Http\Router;

/* ~~~ Application Routes 🚦 ~~~  */

Router::get('/', 'KittensController::index');
Router::get('/kittens', 'KittensController::index');

Router::get('/kitten/{id}', 'KittensController::show');

Router::post('/kitten', 'KittensController::store');

Router::put('/kitten/{id}', 'KittensController::put');

Router::delete('/kitten/{id}', 'KittensController::delete');
