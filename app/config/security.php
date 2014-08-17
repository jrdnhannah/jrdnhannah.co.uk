<?php

$app['security.firewalls'] = [
    'main'  => [
        'pattern' => '^/',
        'form' => ['login_path' => '/login', 'check_path' => '/login/check'],
        'logout' => ['logout_path' => '/logout'],
        'users' => $app['user_provider'],
        'anonymous' => true
    ]
];

$app['security.access_rules'] = [
    ['^/admin', 'ROLE_ADMIN']
];

$app['security.encoder_digest'] = function() {
    return new \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(12);
};