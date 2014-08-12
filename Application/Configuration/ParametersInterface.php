<?php

namespace Application\Configuration;

use Silex\Application;

interface ParametersInterface
{
    public function __construct(Application $app);
    public function build();
}