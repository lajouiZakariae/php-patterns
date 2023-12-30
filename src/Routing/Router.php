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

    private function resolve(): string|array|View|Response
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

    public function go(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    public function to(string $route_name): void
    {
        /** @var ?Route $found_route */
        $found_route = null;

        foreach ($this->routes as $route_list) {

            foreach ($route_list as $route) {
                if ($route->getName() === $route_name) {
                    $found_route = $route;
                }
            }
        }

        $found_route ? $this->go($found_route->getPath()) : null;
    }

    public function response()
    {
        $content = $this->resolve();

        $response = null;

        if ($content instanceof Response) {
            $response = $content;
        } else {
            $response = Response::make($content);
        }

        foreach ($response->getHeaders() as $header => $value) {
            header($header . ': ' . $value);
        };

        echo $response->getBody();
    }
}
