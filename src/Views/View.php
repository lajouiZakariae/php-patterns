<?php

namespace PHPPatterns\Views;

use Twig\Environment;
use Twig\TemplateWrapper;

class View
{
    private static $view_instances = [];

    private Environment $twig;

    private ?TemplateWrapper $template = null;

    private $variables = null;

    private function __construct()
    {
        $this->twig = ViewLoader::instance()->twig(); // Always return the same instance
    }

    public function twig(): Environment
    {
        return $this->twig;
    }

    public function setTemplate($template): void
    {
        $this->template = $template;
    }

    public function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    public function render(): string
    {
        return $this->template->render($this->variables);
    }

    public static function make(string $view_name, array $variables = []): View
    {
        if (!isset(self::$view_instances[$view_name])) {
            self::$view_instances[$view_name] = new self;
        }

        $instance = self::$view_instances[$view_name];

        $template = $instance->twig()->load($view_name . '.html');

        $instance->setTemplate($template);

        $instance->setVariables($variables);

        return $instance;
    }
}
