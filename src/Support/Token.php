<?php

namespace PHPPatterns\Support;

class Token
{
    public static function generate()
    {
        return md5("CSRF_TOKEN" . uniqid(random_bytes(8), true));
    }

    public static function verify(string $token)
    {
        return Session::get("token") === $token;
    }
}
