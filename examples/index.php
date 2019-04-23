<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cherry\Kernel;
use Cherry\Routing\Router;

$kernel = new Kernel(__DIR__);

$router = new Router();
