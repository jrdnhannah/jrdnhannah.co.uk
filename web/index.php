<?php

namespace jrdn;

require_once __DIR__.'/../vendor/autoload.php';

$app = new \Application\App;
$app->debug(true);
$app->boot();