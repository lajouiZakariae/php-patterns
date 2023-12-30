<?php

namespace PHPPatterns\Http;

class Request
{
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
        return isset($_GET[$name]);
    }

    function inputExists(string $name): bool
    {
        return isset($_POST[$name]);
    }

    function param(string $name): mixed
    {
        return $this->paramExists($name) ? $_GET[$name] : null;
    }

    function input(string $name): mixed
    {
        return $this->inputExists($name) ? $_POST[$name] : null;
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
