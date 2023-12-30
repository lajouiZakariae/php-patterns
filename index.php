<?php

use PHPPatterns\Routing\Router;
use PHPPatterns\Views\View;

require './vendor/autoload.php';

$router = new Router;

$router->get('/home', function () {
    return 'hello world';
})->name('index');

$router->get('/about', function () {
    return 'About us';
})->name('about');

$router->get('/hello', function () {
    return View::make('index', ['msg' => 'hello']);
})->name('hello');


$router->response();
