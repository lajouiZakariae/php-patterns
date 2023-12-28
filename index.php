<?php

use PHPPatterns\Event;

require './vendor/autoload.php';

$event = new Event();

$unsub = $event->on('user', function () {
    dump('hello world');
});

$sec_unsub = $event->on('user', function () {
    dump('hello world from listener two');
});

dump($event);

$event->fire('user');

$event->fire('user');

$unsub();

$sec_unsub();

$event->fire('user');

dump($event);
