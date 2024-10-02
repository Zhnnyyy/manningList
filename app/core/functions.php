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
    die();
}