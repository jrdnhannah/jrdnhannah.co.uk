<?php

namespace Application\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** @var \Doctrine\ORM\EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository('Application\Entity\User')->findOneBy(['username' => $username]);

        if (null === $user) {
            $exception = new UsernameNotFoundException;
            $exception->setUsername($username);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        try {
            return $this->loadUserByUsername($user->getUsername());
        } catch (UsernameNotFoundException $e) {
            throw new UnsupportedUserException;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class instanceof UserInterface;
    }

}