<?php

$entityParamConverter = function($entityClass, $value, $field = 'id') use ($app) {
    return $app['orm.em']->getRepository($entityClass)
                         ->findOneBy([$field => $value]);
};

$app->get('/',                  'site.controller:indexAction')
    ->bind('route.home');

$app->get('/contact',           'contact.controller:contactAction')
    ->bind('route.contact');

$app->post('/contact',          'contact.controller:handleContactAction');

$app->get('/news',              'news.controller:showArticleListAction')
    ->bind('route.news');

$app->get('/news/{article}',    'news.controller:showArticleAction')
    ->bind('route.news_article')
    ->convert('article', function ($article) use ($entityParamConverter) {
            return $entityParamConverter('Application\Entity\Article', $article);
        }
    );

return $app;