<?php

namespace PHPPatterns\Auth;

class Auth
{

    private $user;

    public function __construct()
    {
        $this->user = null;
    }

    public function user()
    {
        return $this->user;
    }
}
