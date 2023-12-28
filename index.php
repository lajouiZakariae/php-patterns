<?php

require './vendor/autoload.php';


class Event
{
    private $events = [];

    public function on(string $event_name, callable $callback)
    {
        if (!isset($this->events[$event_name])) {
            $this->events[$event_name] = [$callback];
        }

        return function () use ($event_name, $callback) {

            $filter = function ($value) use ($callback) {
                return $value !== $callback;
            };

            $this->events[$event_name] = array_filter($this->events[$event_name], $filter);
        };
    }

    public function fire(string $event_name)
    {
        if (isset($this->events[$event_name]) && !empty($this->events[$event_name])) {
            foreach ($this->events[$event_name] as $callback) {
                $callback();
            }
        }
    }
}

$event = new Event();

$unsub = $event->on('user', function () {
    dump('hello world');
});

dump($event);

$event->fire('user');

$event->fire('user');

$unsub();

$event->fire('user');

dump($event);
