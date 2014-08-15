<?php

/**
 * Configure Doctrine ORM
 */
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../src/Application/Entity'], $app['debug'], $app['orm.proxies_dir'], null, false);
$em = \Doctrine\ORM\EntityManager::create($app['db.options'], $config);