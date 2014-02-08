<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Kpacha\ReactiveSilex\ReactiveApplication;
$app['debug'] = true;

$app->get('/', function () {
    return "Welcome to the REACTiveApplication homepage, powered by react & silex (and some espresso)\n";
});

$app->get('/favicon.ico', function () {
    return "";
});

$app->get('/humans.txt', function () {
    return "I believe you are a humanoid robot.\n";
});

echo "Server running at http://127.0.0.1:1337\n";

$stack = new Kpacha\ReactiveSilex\Stack($app);
$stack->listen(1337);