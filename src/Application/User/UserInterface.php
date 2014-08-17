<?php

namespace Application\User;

use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    /**
     * Set the users password
     *
     * @param $password
     * @return $this
     */
    public function setPassword($password);
}