<?php

$articleConverter = function ($articleId) use ($entityParamConverter) {
    return $entityParamConverter('Application\Entity\Article', $articleId);
};

$app->get('/news', 'news.controller:showCollectionAction')
    ->bind('route.news');

$app->get('/news/{entity}', 'news.controller:showItemAction')
    ->bind('route.news_article')
    ->convert('entity', $articleConverter);

$app->match('/admin/article', 'news.controller:createAction')
    ->method('GET|POST')
    ->bind('route.admin.news_article');

$app->match('/admin/article/{entity}/edit', 'news.controller:editAction')
    ->method('GET|POST|PUT')
    ->bind('route.admin.edit_news_article')
    ->convert('entity', $articleConverter);

$app->match('admin/article/{entity}/confirm_delete', 'news.controller:confirmDeleteAction')
    ->method('GET')
    ->bind('route.admin.confirm_delete_news_article')
    ->convert('entity', $articleConverter);

$app->match('/admin/article/{entity}/delete', 'news.controller:deleteAction')
    ->method('GET|DELETE')
    ->bind('route.admin.delete_news_article')
    ->convert('entity', $articleConverter);

return $app;