<?php

$app['site.controller'] = function () use ($app) {
    return new \Application\Controller\SiteController($app['twig']);
};

$app['contact.controller'] = function () use ($app) {
    return new \Application\Controller\ContactController(
        $app['twig'],
        $app['form.factory'],
        $app['mailer'],
        $app['mail.to'],
        $app['mail.from']
    );
};

$app['news.controller'] = function() use ($app) {
    return new \Application\Controller\NewsController(
        $app['twig'],
        $app['orm.em'],
        $app['form.factory']
    );
};

$app['auth.controller'] = function() use ($app) {
    return new \Application\Controller\AuthenticationController(
        $app['twig'],
        $app['security.last_error'],
        $app['session']
    );
};

return $app;