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
        $app['orm.em']
    );
};

return $app;