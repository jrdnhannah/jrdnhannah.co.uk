<?php

namespace Application\Controller;

use Application\Entity\Article;
use Application\Entity\User;
use Application\Exception\InvalidFormException;
use Application\User\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /** @var \Symfony\Component\Form\FormFactoryInterface */
    private $form;

    /**
     * @param \Twig_Environment $twig
     * @param EntityManagerInterface $em
     * @param FormFactoryInterface $form
     */
    public function __construct(\Twig_Environment $twig, EntityManagerInterface $em, FormFactoryInterface $form)
    {
        $this->twig = $twig;
        $this->em   = $em;
        $this->form = $form;
    }

    /**
     * @return string
     */
    public function showArticleListAction()
    {
        /** @var Article[] $articleList */
        $articleList = $this->em->getRepository('Application\Entity\Article')->findBy([], ['createdAt' => 'desc']);

        return $this->twig->render('news/article_list.html.twig', ['article_list' => $articleList]);
    }

    /**
     * @param Article $article
     * @return string
     */
    public function showArticleAction(Article $article)
    {
        return $this->twig->render('news/article.html.twig', ['article' => $article]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function createArticleAction(Request $request)
    {
        $handler = function(FormInterface $form) {
            $this->em->persist($form->getData());
            $this->em->flush();
        };

        try {
            $this->handleForm($request, $handler);
            return $this->twig->render('news/admin/success.html.twig');
        } catch (InvalidFormException $e) {
            return $this->twig->render(
                'news/admin/create.html.twig',
                ['form' => $e->getForm()->createView()]
            );
        }
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return string
     */
    public function editArticleAction(Request $request, Article $article)
    {
        $handler = function() {
            $this->em->flush();
        };

        try {
            $this->handleForm($request, $handler, $article, 'PUT');
            return $this->twig->render('news/admin/success.html.twig');
        } catch (InvalidFormException $e) {
            return $this->twig->render(
                'news/admin/create.html.twig',
                ['form' => $e->getForm()->createView()]
            );
        }
    }

    /**
     * @param  Article $article
     * @return string
     */
    public function deleteArticleAction(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();

        return $this->twig->render('news/admin/success.html.twig');
    }

    /**
     * @param Request  $request
     * @param \Closure $handler
     * @param Article  $article
     * @return \Symfony\Component\Form\Form
     * @throws \Application\Exception\InvalidFormException
     */
    private function handleForm(Request $request, \Closure $handler, Article $article = null)
    {
        $form = $this->createArticleForm($article);
        $form->handleRequest($request);

        if (true === $form->isValid()) {
            $handler($form);
            return $form;
        }

        throw new InvalidFormException($form);
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\Form\Form
     */
    private function createArticleForm(Article $article = null)
    {
        return $this->form->createBuilder('form', $article, ['data_class' => 'Application\Entity\Article'])
                           ->add('title', 'text', ['required' => true])
                           ->add('content', 'textarea', ['required' => true])
                           ->add('Post', 'submit')
                           ->getForm();

    }
}