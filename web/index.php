<?php

namespace jrdn;

use Application\Controller\SiteController;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

// Create application
$app = new Application;

// Enable debug
$app['debug'] = true;

// Register service providers
$app->register(new TwigServiceProvider, ['twig.path' => __DIR__.'/../views']);
$app->register(new ServiceControllerServiceProvider);

// Create controllers as services
$app['site.controller'] = $app->share(function() use ($app) {
    return new SiteController($app['twig']);
});

// Map routes to controllers
$app->get('/', 'site.controller:indexAction');

// Let's go!
$app->run();