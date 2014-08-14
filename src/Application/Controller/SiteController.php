<?php

namespace Application\Controller;

class SiteController
{
    /** @var \Twig_Environment */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return string
     */
    public function indexAction()
    {
        return $this->twig->render('main/index.html.twig');
    }
}