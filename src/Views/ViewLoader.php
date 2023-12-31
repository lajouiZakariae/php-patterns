<?php

namespace PHPPatterns\Views;

use PHPPatterns\Support\Singleton;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewLoader
{
    use Singleton;

    private FilesystemLoader $loader;

    private Environment $twig;

    private function __construct()
    {
        $this->loader = new FilesystemLoader(base_path('views'));
        $this->twig = new Environment($this->loader, []);
    }

    public function twig(): Environment
    {
        return $this->twig;
    }
}
