<?php

use Core\Http\Router;

/* ~~~ Application Routes 🚦 ~~~  */

Router::get('/', 'KittensController::index');
Router::get('/kittens', 'KittensController::index');

Router::get('/kittens/{id}', 'KittensController::show');

Router::post('/kittens', 'KittensController::store');

Router::put('/kittens/{id}', 'KittensController::put');

Router::delete('/kittens/{id}', 'KittensController::delete');
