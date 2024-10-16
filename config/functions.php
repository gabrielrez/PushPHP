<?php

/* ~~~ Helper Functions 🔧 ~~~  */

function push($stuff)
{
    echo $stuff;
}

function dd(...$stuff)
{
    foreach ($stuff as $item) {
        echo "<pre>";
        var_dump($item);
        echo "</pre>";
    }
    die;
}

function response(?int $statusCode = null, ?array $data = null)
{
    return (new Core\Response())
        ->setStatusCode($statusCode)
        ->json($data)
        ->send();
}
