<?php

namespace Application\Controller;

use Application\Entity\Article;
use Application\Entity\User;
use Application\Exception\InvalidFormException;
use Application\User\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use string;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NewsController extends FormHandlerController
{
    /**
     * {@inheritdoc}
     */
    protected function getEntityName()
    {
        return 'News Article';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return 'Application\Entity\Article';
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm($entity = null)
    {
        return $this->getFormFactory()
                    ->createBuilder('form', $entity, ['data_class' => $this->getEntityClass()])
                    ->add('title', 'text', ['required' => true])
                    ->add('content', 'textarea', ['required' => true])
                    ->add('Post', 'submit')
                    ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    protected function getViews()
    {
        return [
            'single' => 'news/article.html.twig',
            'list'   => 'news/article_list.html.twig',
            'create' => 'news/admin/create.html.twig',
            'confirm_delete' => 'news/admin/confirm_delete.html.twig'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutes()
    {
        return [
            'list' => 'route.news',
            'single' => 'route.news_article'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getCollectionCriteria()
    {
        return ['createdAt' => 'desc'];
    }


}