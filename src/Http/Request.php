<?php

namespace PHPPatterns\Http;

use PHPPatterns\Support\Singleton;

class Request
{
    use Singleton;

    private array $inputs = [];

    private array $params = [];

    private string $path = "";

    public function __construct()
    {
        if (empty($this->inputs)) {
            foreach ($_POST as $key => $value) {
                $this->inputs[$key] = $value;
            }
        }

        if (empty($this->params)) {
            foreach ($_GET as $key => $value) {
                $this->params[$key] = $value;
            }
        }

        $this->setPath();
    }

    function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    function setPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'])["path"];
        $this->path = ($path === null || strlen($path) === 0) ?  "/" : $path;
    }

    function path()
    {
        return $this->path;
    }

    function paramExists(string $name): bool
    {
        return isset($this->params[$name]);
    }

    function inputExists(string $name): bool
    {
        return isset($this->inputs[$name]);
    }

    function param(string $name): mixed
    {
        return $this->paramExists($name) ? $this->params[$name] : null;
    }

    function input(string $name): mixed
    {
        return $this->inputExists($name) ? $this->inputs[$name] : null;
    }

    function paramIsInteger(string $name): bool
    {
        return filter_var($this->param($name), FILTER_VALIDATE_INT) !== false;
    }

    function inputIsInteger(string $name): bool
    {
        return filter_var($this->input($name), FILTER_VALIDATE_INT) !== false;
    }

    function paramInteger(string $name): ?int
    {
        return $this->paramIsInteger($name) ? $this->param($name) : null;
    }

    function inputInteger(string $name): ?int
    {
        return $this->inputIsInteger($name) ? $this->input($name) : null;
    }

    function whenParam(string $name, mixed $value, callable $func): void
    {
        if ($this->param($name) === $value) {
            $func();
        }
    }

    function whenInput(string $name, mixed $value, callable $func): void
    {
        if ($this->input($name) === $value) {
            $func();
        }
    }
}
