<?php

$providers = [
    [new \Silex\Provider\TwigServiceProvider, ['twig.path' => __DIR__ . '/../../views']],
    [new \Silex\Provider\TranslationServiceProvider, ['locale_fallback' => 'en']],
    [new \Silex\Provider\ServiceControllerServiceProvider],
    [new \Silex\Provider\UrlGeneratorServiceProvider],
    [new \Silex\Provider\FormServiceProvider],
    [new \Silex\Provider\SwiftmailerServiceProvider],
    [new \Silex\Provider\DoctrineServiceProvider]
];

return $providers;