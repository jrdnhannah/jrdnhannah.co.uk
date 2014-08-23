<?php

$portfolioConverter = function ($portfolioItemId) use ($entityParamConverter) {
    return $entityParamConverter('Application\Entity\PortfolioItem', $portfolioItemId);
};

$app->get('/portfolio', 'portfolio.controller:showCollectionAction')
    ->bind('route.portfolio');

$app->get('/portfolio/{entity}', 'portfolio.controller:showItemAction')
    ->bind('route.portfolio_item')
    ->convert('entity', $portfolioConverter);

$app->match('/admin/portfolio', 'portfolio.controller:createAction')
    ->method('GET|POST')
    ->bind('route.admin.portfolio_item');

$app->match('/admin/portfolio/{entity}/edit', 'portfolio.controller:editAction')
    ->method('GET|POST|PUT')
    ->bind('route.admin.edit_portfolio_item')
    ->convert('entity', $portfolioConverter);

$app->match('admin/portfolio/{entity}/confirm_delete', 'portfolio.controller:confirmDeleteAction')
    ->method('GET')
    ->bind('route.admin.confirm_delete_portfolio_item')
    ->convert('entity', $portfolioConverter);

$app->match('/admin/portfolio/{entity}/delete', 'portfolio.controller:deleteAction')
    ->method('GET|DELETE')
    ->bind('route.admin.delete_portfolio_item')
    ->convert('entity', $portfolioConverter);

return $app;