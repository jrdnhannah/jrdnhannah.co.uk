<?php

namespace Application\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager
{
    /** @var EntityManagerInterface */
    protected $em;

    /** @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface */
    protected $encoderFactory;

    public function __construct(EntityManagerInterface $em, EncoderFactoryInterface $encoderFactory)
    {
        $this->em = $em;
        $this->encoderFactory = $encoderFactory;
    }

    public function createUser(UserInterface $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));

        $this->em->persist($user);
        $this->em->flush();
    }
}