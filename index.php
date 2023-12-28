<?php

use PHPPatterns\Event;

require './vendor/autoload.php';

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
