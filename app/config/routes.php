<?php

$entityParamConverter = function ($entityClass, $value, $field = 'id') use ($app) {
    return $app['orm.em']->getRepository($entityClass)
                         ->findOneBy([$field => $value]);
};

$app->get('/',                  'site.controller:indexAction')
    ->bind('route.home');

$app->get('/contact',           'contact.controller:contactAction')
    ->bind('route.contact');

$app->post('/contact',          'contact.controller:handleContactAction');

require_once __DIR__ . '/routing/portfolio.php';

require_once __DIR__ . '/routing/news.php';

$app->get('/admin', function() {
        return new \Symfony\Component\HttpFoundation\RedirectResponse('/admin/article');
    }
);

$app->get('/login', 'auth.controller:loginAction');

return $app;