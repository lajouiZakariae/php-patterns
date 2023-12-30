<?php

namespace PHPPatterns\Routing;

class Route
{
    private string $name;

    public function __construct(
        private string $method,
        private string $path,
        private $callback,
    ) {
    }

    function name($name): Route
    {
        $this->name = $name;
        return $this;
    }

    function fire(): mixed
    {
        return call_user_func($this->callback);
    }
}
