<?php

namespace PHPPatterns\Events;

class Event
{
    /** @var Handler[] */
    private $events = [];

    public function on(string $event_name, callable $callback)
    {
        $this->events[$event_name] = new Handler($callback);

        return function () use ($event_name) {
            unset($this->events[$event_name]);
        };
    }

    private function eventExists(string $event_name): bool
    {
        return isset($this->events[$event_name]);
    }

    private function eventMissing(string $event_name): bool
    {
        return !$this->eventExists($event_name);
    }

    public function dispatch(string $event_name, ...$args)
    {
        if ($this->eventExists($event_name)) {
            $handler = $this->events[$event_name];
            $handler->fire($args);
        }
    }

    public function callCount(string $event_name): int
    {
        if ($this->eventMissing($event_name)) {
            return 0;
        }

        return $this->events[$event_name]->getCount();
    }
}
