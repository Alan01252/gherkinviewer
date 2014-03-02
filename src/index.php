<?php
use GherkinViewer\services\GherkinParser;

require_once __DIR__ . '/../vendor/autoload.php';


$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['GherkinParser'] = function () {
    return new GherkinParser();
};

$app['FeatureExtractor'] = function() use ($app) {
    return new \GherkinViewer\services\FeatureExtractor(__DIR__ . '/../features/', $app['GherkinParser']);
};

$app->get('/', function () use ($app) {
    $feature = file_get_contents(__DIR__ . '/../features/DisplayFeature.feature');

    return $app['twig']->render('feature.twig', [
           'feature' => $app['GherkinParser']->parseFeature($feature)
        ]
    );
});

$app->get('/features', function () use ($app) {

    return $app['twig']->render('features.twig', [
           'features' => $app['FeatureExtractor']->getFeatures()
        ]
    );
});

$app->run();

