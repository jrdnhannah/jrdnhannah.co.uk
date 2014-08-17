<?php

$app['user_provider'] = function (\Silex\Application $app) {
    return new \Application\User\UserProvider($app['orm.em']);
};

$app['user_manager'] = function(\Silex\Application $app) {
    return new \Application\User\UserManager($app['orm.em'], $app['security.encoder_factory']);
};