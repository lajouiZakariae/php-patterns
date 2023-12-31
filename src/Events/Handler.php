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

    public function fire($args): void
    {
        $cb = $this->callback;
        $cb(...$args);
        $this->incrementCalls();
    }

    public function getCallback(): callable
    {
        return $this->callback;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    private function incrementCalls(): void
    {
        $this->count++;
    }
}
