<?php

namespace PHPPatterns\Http;

use Exception;
use PHPPatterns\support\Singleton;
use PHPPatterns\Views\View;

class Response
{
    use Singleton;

    private array $headers = [];

    private int $status_code = 200;

    private $body = '';

    protected function __construct(View|array|string $content)
    {
        if (is_string($content)) {
            $this->body = $content;
        } elseif ($content instanceof View) {
            $this->body = $content->render();
        } elseif (is_array($content)) {
            $this->body = json_encode($content);
        }
    }

    public function status(int $status_code)
    {
        $this->status_code = $status_code;
    }

    public static function make(View|array|string $content): Response
    {
        return self::instance($content);
    }
}
