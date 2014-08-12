<?php

namespace jrdn;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \Silex\Application;

require_once __DIR__ . '/../app/bootstrap.php';

$app['debug'] = true;
$app->run();