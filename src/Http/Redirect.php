<?php

namespace PHPPatterns\Http;

use Exception;
use PHPPatterns\Routing\Route;
use PHPPatterns\Routing\Router;

class Redirect
{
    private ?string $destination = null;

    public function __construct(string|null $url)
    {
        $this->destination = $url;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }
    /**
     * Redirects to a name route
     * @param string $route_name Name of Route
     */
    public function to(string $route_name): Redirect
    {
        $route_list = Router::instance()->getRoutes();

        /** @var Route|null */
        $found_route = null;

        foreach ($route_list as $method => $routes) {
            foreach ($routes as $route) {
                if ($route->getName() == $route_name) {
                    $found_route = $route;
                }
            }
        }

        if (!$found_route) {
            throw new Exception('Named Route Not Found!');
        }

        $this->destination = $found_route->getPath();

        return $this;
    }
}
