<?php

require_once __DIR__ . '/../vendor/autoload.php';

$silexApp = require_once __DIR__ . '/../src/app.php';
$stack = new Kpacha\ReactiveSilex\Stack($silexApp);

echo "Server running at http://127.0.0.1:1337\n";

$stack->listen(1337);