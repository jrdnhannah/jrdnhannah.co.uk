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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NewsController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /** @var \Symfony\Component\Form\FormFactoryInterface */
    private $form;

    /** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $urlGenerator;

    /**
     * @param \Twig_Environment $twig
     * @param EntityManagerInterface $em
     * @param FormFactoryInterface $form
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        \Twig_Environment $twig,
        EntityManagerInterface $em,
        FormFactoryInterface $form,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->twig = $twig;
        $this->em   = $em;
        $this->form = $form;
        $this->urlGenerator = $urlGenerator;
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
        $handler = function(Request $request, FormInterface $form) {
            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add('notice', 'Article successfully created.');
            $this->em->persist($form->getData());
            $this->em->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate('route.news_article', ['article' => $form->getData()->getId()])
            );
        };

        try {
            return $this->handleForm($request, $handler);
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
        $handler = function(Request $request, FormInterface $form) {
            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add('notice', 'Article successfully updated.');

            $form->getData()->markUpdated();

            $this->em->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate('route.news_article', ['article' => $form->getData()->getId()])
            );
        };

        try {
            return $this->handleForm($request, $handler, $article);
        } catch (InvalidFormException $e) {
            return $this->twig->render(
                'news/admin/create.html.twig',
                ['form' => $e->getForm()->createView()]
            );
        }
    }

    /**
     * @param Article $article
     * @return string
     */
    public function confirmDeleteArticleAction(Article $article)
    {
        return $this->twig->render('news/admin/confirm_delete.html.twig', ['article' => $article]);
    }

    /**
     * @param  Request $request
     * @param  Article $article
     * @return string
     */
    public function deleteArticleAction(Request $request, Article $article)
    {
        /** @var Session $session */
        $session = $request->getSession();
        $session->getFlashBag()->add('notice', 'Article successfully deleted.');

        $this->em->remove($article);
        $this->em->flush();

        return new RedirectResponse(
            $this->urlGenerator->generate('route.news')
        );
    }

    /**
     * @param Request $request
     * @param \Closure $handler
     * @param Article $article
     * @param Response $response
     * @throws \Application\Exception\InvalidFormException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function handleForm(Request $request, \Closure $handler, Article $article = null, Response $response = null)
    {
        $form = $this->createArticleForm($article);
        $form->handleRequest($request);

        if (true === $form->isValid()) {
            if (($handlerResponse = $handler($request, $form)) instanceof Response) {
                return $handlerResponse;
            }

            return $response instanceof Response ?: new Response();
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