<?php
use GherkinViewer\services\FeatureFinder;
use GherkinViewer\services\GherkinParser;

require_once __DIR__ . '/../vendor/autoload.php';


$app = new Silex\Application();

$app['config'] = [
    'featureDir' => __DIR__ . '/../features/'
];

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));

$app['GherkinParser'] = function () {
    return new GherkinParser();
};

$app['FeatureFinder'] = function () use ($app) {
    return new FeatureFinder($app['config']['featureDir'], $app['GherkinParser']);
};

$app->get('/features', function () use ($app) {

    return $app['twig']->render('features.twig', [
            'features' => $app['FeatureFinder']->findAllFeatureTitles()
        ]
    );
});

$app->get('/feature/{featureTitle}', function ($featureTitle) use ($app) {

    return $app['twig']->render('feature.twig', [
            'feature' => $app['FeatureFinder']->findByTitle($featureTitle)
        ]
    );
});

$app->run();
