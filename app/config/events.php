<?php

use \Knp\Console\ConsoleEvent;
use \Knp\Console\ConsoleEvents;

$app['dispatcher']->addListener(ConsoleEvents::INIT, function(ConsoleEvent $e) {
        $e->getApplication()->add(new \Application\Command\CreateUserCommand);
    }
);

return $app;