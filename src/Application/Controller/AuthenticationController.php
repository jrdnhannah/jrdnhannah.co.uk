<?php

namespace Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthenticationController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var string */
    private $lastError;

    /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface */
    private $session;

    public function __construct(\Twig_Environment $twig, $lastError, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->lastError = $lastError;
        $this->session = $session;
    }

    public function loginAction(Request $request)
    {
        return $this->twig->render('security/login_form.html.twig', [
                'error' => call_user_func($this->lastError, $request),
                'last_username' => $this->session->get('_security.last_username')
            ]
        );
    }
}