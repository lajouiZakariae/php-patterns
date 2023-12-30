<?php

namespace PHPPatterns\Routing;

use PHPPatterns\Http\Request;
use PHPPatterns\Http\Response;
use PHPPatterns\Views\View;

class Router
{
    private $routes  = [];

    function get(string $path, $callback): Route
    {
        $route = new Route('get', $path, $callback);

        $this->routes['get'][$path] = $route;

        return $route;
    }

    function post(string $path, $callback): Route
    {
        $route = new Route('post', $path, $callback);

        $this->routes['post'][$path] = $route;

        return $route;
    }

    function put(string $path, $callback): Route
    {
        $route = new Route('put', $path, $callback);

        $this->routes['put'][$path] = $route;

        return $route;
    }

    function delete(string $path, $callback): Route
    {
        $route = new Route('delete', $path, $callback);

        $this->routes['delete'][$path] = $route;

        return $route;
    }

    function patch(string $path, $callback): Route
    {
        $route = new Route('patch', $path, $callback);

        $this->routes['patch'][$path] = $route;

        return $route;
    }

    private function resolve(): string|array|View
    {
        $request = new Request;

        $method = $request->method();
        $path = $request->path();

        /** @var ?Route */
        $route = null; // handle null

        if (isset($this->routes[$method]) && isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
        }

        return $route->fire();
    }

    public function response()
    {
        $content = $this->resolve();

        dump(Response::make($content));
    }
}
