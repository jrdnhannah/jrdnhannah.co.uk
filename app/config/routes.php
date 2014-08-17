<?php

$entityParamConverter = function($entityClass, $value, $field = 'id') use ($app) {
    return $app['orm.em']->getRepository($entityClass)
                         ->findOneBy([$field => $value]);
};

$articleConverter = function($articleId) use ($entityParamConverter) {
    return $entityParamConverter('Application\Entity\Article', $articleId);
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
    ->convert('article', $articleConverter);

$app->match('/admin/article',     'news.controller:createArticleAction')
    ->method('GET|POST')
    ->bind('route.admin.news_article');

$app->match('/admin/article/{article}/edit', 'news.controller:editArticleAction')
    ->method('GET|POST|PUT')
    ->bind('route.admin.edit_news_article')
    ->convert('article', $articleConverter);

$app->match('admin/article/{article}/confirm_delete', 'news.controller:confirmDeleteArticleAction')
    ->method('GET')
    ->bind('route.admin.confirm_delete_news_article')
    ->convert('article', $articleConverter);

$app->match('/admin/article/{article}/delete', 'news.controller:deleteArticleAction')
    ->method('GET|DELETE')
    ->bind('route.admin.delete_news_article')
    ->convert('article', $articleConverter);

$app->get('/admin', function() {
        return new \Symfony\Component\HttpFoundation\RedirectResponse('/admin/article');
    }
);

$app->get('/login', 'auth.controller:loginAction');

return $app;