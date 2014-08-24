<?php

namespace Application\Model;

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