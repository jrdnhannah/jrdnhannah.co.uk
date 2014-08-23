<?php

namespace Application\Entity;

interface AdminAccessible
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();
}