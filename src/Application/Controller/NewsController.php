<?php

namespace Application\Controller;

use Application\Entity\AdminAccessible;

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
    protected function getGroupedName()
    {
        return 'News';
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
    protected function createForm(AdminAccessible $entity = null)
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