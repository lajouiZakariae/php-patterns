<?php

use PHPPatterns\Routing\Router;
use PHPPatterns\Support\File;
use PHPPatterns\Views\View;

$config = require('../config.php');
require('../functions.php');

function base_path(string $path = ''): string
{
    global $config;
    return $config['BASE_PATH'] . ($path === '' ? '' : '/') . $path;
}

require '../vendor/autoload.php';

require '../web.php';
