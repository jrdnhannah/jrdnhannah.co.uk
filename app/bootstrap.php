<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app          = new \Silex\Application;
$app['debug'] = true;

/**
 * Load controllers
 */
require_once 'config/controllers.php';

/**
 * Load routes
 */
require_once 'config/routes.php';

/**
 * Load service providers
 */
require_once 'config/providers.php';

foreach ($providers as $provider) {
    if (count($provider) > 1) {
        $app->register($provider[0], $provider[1]);
    } else {
        $app->register($provider[0]);
    }
}

/**
 * Load application parameters
 */
require_once 'config/parameters.php';