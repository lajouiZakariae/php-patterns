<?php

namespace PHPPatterns\Http;

use Header;
use PHPPatterns\Support\Singleton;
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

            $this->header('Content-Type', 'application/json');
        }
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set status code
     */
    public function status(int $status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    /**
     * Set a Header
     * @param Header  $header
     */
    public function header($header, string $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }


    /**
     * Set Accept header
     */
    public function headerAccept(string $value)
    {
        $this->header(Header::ACCEPT,  $value);
        return $this;
    }

    /**
     * Set Accept header
     */
    public function headerContentType(string $value)
    {
        $this->header(Header::ACCEPT, $value);
        return $this;
    }

    public static function make(View|array|string $content): Response
    {
        return self::instance($content);
    }
}
