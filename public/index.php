<?php
session_start();
require "../app/core/init.php";
// var_dump($_SERVER);
$app = new App;
$app->loadController();
