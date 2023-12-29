<?php

use PHPPatterns\Events\Event;

require './vendor/autoload.php';

$event = new Event();

$unsub = $event->on('user', function (string $msg = 'nice', int $age = 18) {
    dump('hello world');
    dump($msg, $age);
});

dump($event);

$event->dispatch('user', 'hello', 18);

// dump($event->callCount('user')); // 1

$event->dispatch('user');

// dump($event->callCount('user')); // 2

$unsub();
