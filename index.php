<?php

use PHPPatterns\Events\Event;

require './vendor/autoload.php';

$event = new Event();

$unsub = $event->on('user', function () {
    dump('hello world');
});

dump($event);

$event->dispatch('user');

dump($event->callCount('user')); // 1

$event->dispatch('user');

dump($event->callCount('user')); // 2

$unsub();
