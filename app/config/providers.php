<?php

$providers = [
    [new \Silex\Provider\TwigServiceProvider, ['twig.path' => __DIR__ . '/../../views']],
    [new \Silex\Provider\LocaleServiceProvider],
    [new \Silex\Provider\TranslationServiceProvider, ['locale_fallback' => 'en']],
    [new \Silex\Provider\ServiceControllerServiceProvider],
    [new \Silex\Provider\RoutingServiceProvider],
    [new \Silex\Provider\FormServiceProvider],
    [new \Silex\Provider\SwiftmailerServiceProvider],
    [new \Silex\Provider\DoctrineServiceProvider],
    [new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider]
];

return $providers;