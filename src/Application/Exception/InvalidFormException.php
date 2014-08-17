<?php

namespace Application\Exception;

use Symfony\Component\Form\FormInterface;

class InvalidFormException extends \Exception
{
    /** @var \Symfony\Component\Form\Test\FormInterface  */
    private $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}