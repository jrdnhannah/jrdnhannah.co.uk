<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app          = new \Silex\Application;
$app['debug'] = true;

/**
 * Load application parameters
 */
require_once __DIR__ . '/config/parameters.php';

/**
 * Load application services
 */

require_once __DIR__ . '/config/services.php';

/**
 * Load controllers
 */
require_once __DIR__ . '/config/controllers.php';

/**
 * Load routes
 */
require_once __DIR__ . '/config/routes.php';

/**
 * Load service providers
 */
require_once __DIR__ . '/config/providers.php';

foreach ($providers as $provider) {
    if (count($provider) > 1) {
        $app->register($provider[0], $provider[1]);
    } else {
        $app->register($provider[0]);
    }
}

/**
 * Load security
 */
require_once __DIR__ . '/config/security.php';

/**
 * Load annotations register
 */
require_once __DIR__ . '/config/annotations.php';

/**
 * Load doctrine config
 */
require_once __DIR__ . '/config/doctrine.php';

return $app;