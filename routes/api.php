<?php

use Core\Router;

/* ~~~ Application Routes 🚦 ~~~  */

Router::get('/', function () {
    $data = [
        'title' => 'PushPHP',
        'message' => 'A minimalist template for creating web applications with PHP',
    ];

    respond($data);
});
