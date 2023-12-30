<?php

namespace PHPPatterns\Support;

trait Singleton
{
    protected static $inst = null;

    protected function __construct()
    {
    }

    public static function instance(...$args): self
    {
        if (!self::$inst) {
            self::$inst = new static(...$args);
        }

        return self::$inst;
    }
}
