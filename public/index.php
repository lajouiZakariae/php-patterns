<?php

use PHPPatterns\Routing\Router;
use PHPPatterns\Views\View;

$config = require('../config.php');

function base_path(string $path = ''): string
{
    global $config;
    return $config['BASE_PATH'] . ($path === '' ? '' : '/') . $path;
}

require '../vendor/autoload.php';

$router = new Router;

$router->get('/home', function () {
    return 'hello world';
})->name('index');

$router->get('/about', function () {
    return 'About us';
})->name('about');

$router->get('/hello', function () {
    // return ['hello world'];
    return View::make('index', ['msg' => 'hello']);
})->name('hello');


$router->response();
