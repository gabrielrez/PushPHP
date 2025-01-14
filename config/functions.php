<?php

/* ~~~ Helper Functions 🔧 ~~~  */

use Core\Controller;
use Core\Request;
use Core\Response;

/**
 * Displays the content of a variable.
 * 
 * @param mixed $something The content to be displayed.
 * @return void
 */
function push(mixed $something): void
{
    echo $something;
}

/**
 * Dumps and displays the content of variables, then terminates the script.
 * 
 * @param mixed ...$somethings The variables to be displayed.
 * @return void
 */
function dd(mixed ...$somethings): void
{
    foreach ($somethings as $something) {
        push("<pre>");
        var_dump($something);
    }

    die;
}

function abort(?string $message = null, int $status_code = 404): void
{
    if (is_null($message)) {
        $message = 'Aborted with status code ' . $status_code;
    }

    http_response_code($status_code);
    echo json_encode(['error' => $message]);
    exit;
}
