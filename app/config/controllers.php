<?php

$app['site.controller'] = $app->share(function () use ($app) {
        return new \Application\Controller\SiteController($app['twig']);
    }
);

$app['contact.controller'] = $app->share(function () use ($app) {
        return new \Application\Controller\ContactController(
            $app['twig'],
            $app['form.factory'],
            $app['mailer'],
            $app['mail.to'],
            $app['mail.from']
        );
    }
);

return $app;