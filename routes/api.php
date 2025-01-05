<?php

use Core\Router;

/* ~~~ Application Routes 🚦 ~~~  */

Router::get('/', function () {
    $data = [
        'title' => 'PushPHP',
        'message' => 'A minimalist template for creating web applications with PHP',
        'status_code' => get_status_code() // 200
    ];

    respond($data);
});
