<?php

use PHPPatterns\Http\Response;
use PHPPatterns\Routing\Router;
use PHPPatterns\Views\View;

$router = Router::instance();

$router->get('/html', function () {
    return 'hello world';
})->name('html');

$router->get('/json', function () {
    return ['name' => 'zakariae'];
});

$router->get('/view', function () {
    return View::make('index', ['msg' => 'hello']);
})->name('twig_view');

$router->get('/old', function () {
    return Response::redirect()->to('new_route');
})->name('old_route');

$router->get('/new', function () {
    return View::make('index', ['msg' => 'You have been redirected to this route']);
})->name('new_route');

$router->fallback(fn () => Response::make(['msg' => '404 Not Found'])->status(404));

$router->respond();
