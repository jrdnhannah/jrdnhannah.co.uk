<?php

$app->get('/',         'site.controller:indexAction')->bind('route.home');
$app->get('/contact',  'contact.controller:contactAction')->bind('route.contact');
$app->post('/contact', 'contact.controller:handleContactAction');

return $app;