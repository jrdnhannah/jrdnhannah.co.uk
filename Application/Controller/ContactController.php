<?php

namespace Application\Controller;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class ContactController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Symfony\Component\Form\FormFactoryInterface */
    private $form;

    /** @var \Swift_Mailer */
    private $mailer;

    /** @var array */
    private $mailTo;

    /** @var array */
    private $mailFrom;

    /**
     * @param \Twig_Environment     $twig
     * @param FormFactoryInterface  $form
     * @param \Swift_Mailer         $mailer
     */
    public function __construct(\Twig_Environment $twig, FormFactoryInterface $form, \Swift_Mailer $mailer, array $mailTo, array $mailFrom)
    {
        $this->twig   = $twig;
        $this->form   = $form;
        $this->mailer = $mailer;
        $this->mailTo = $mailTo;
        $this->mailFrom = $mailFrom;
    }

    /**
     * @return string
     */
    public function contactAction(Request $request)
    {
        $form = $this->createContactForm();

        $form->handleRequest($request);

        return $this->twig->render('main/contact.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function handleContactAction(Request $request)
    {
        $form = $this->createContactForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $message = \Swift_Message::newInstance('[Site Feedback]');
            $message->setTo($this->mailTo)
                ->setFrom($this->mailFrom)
                ->setReplyTo($form->getData()['email'], $form->getData()['name'])
                ->setBody($this->twig->render('contact/message.html.twig', $form->getData()), 'text/html');

            $this->mailer->send($message);

            return $this->twig->render('main/contact_success.html.twig', $form->getData());
        }

        return $this->twig->render('main/contact_failure.html.twig');
    }

    /**
     * @return FormInterface
     */
    private function createContactForm()
    {
        return $this->form->createBuilder('form', null, ['action' => '/contact'])
            ->add('name', 'text', ['label' => 'Your Name'])
            ->add('email', 'email', ['label' => 'Your Email'])
            ->add('message', 'textarea', ['label' => 'Message'])
            ->add('Send', 'submit')
            ->getForm();
    }
}