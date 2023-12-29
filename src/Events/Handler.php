<?php

namespace PHPPatterns\Events;

class Handler
{
    private int $count = 0;

    public function __construct(
        /** @var callable */
        private $callback
    ) {
    }

    public function fire(): void
    {
        $cb = $this->callback;
        $cb();
        $this->increment();
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    private function increment(): void
    {
        $this->count++;
    }

    private function decrement(): void
    {
        $this->count++;
    }
}
