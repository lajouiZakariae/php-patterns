<?php

namespace PHPPatterns\Routing;

use PHPPatterns\Http\Request;

class Route
{
    private ?string $name = null;

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

    function getPath(): string
    {
        return $this->path;
    }

    function getName(): ?string
    {
        return $this->name;
    }

    function fire(): mixed
    {
        if (is_array($this->callback)) {
            [$class, $method] = $this->callback;
            return call_user_func([new $class(), $method], new Request);
        }
        return call_user_func($this->callback);
    }
}
