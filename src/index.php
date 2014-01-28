<?php
require_once __DIR__ . '/../vendor/autoload.php';


$app = new Silex\Application();

$app->get('/', function() use ($app) {
    $feature = file_get_contents(__DIR__ . '/../features/DisplayFeature.feature');

    return nl2br($feature);
});

$app->run();

