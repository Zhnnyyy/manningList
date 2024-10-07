<?php

function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    exit();
}
function root()
{
    return;
}

function redirect($path)
{
    header("Location: " . "http://localhost/manninglist" . "/" . $path);
    // header("Location: " . "http://localhost:3002" . "/" . $path);
    die();
}