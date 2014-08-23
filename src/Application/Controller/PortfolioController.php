<?php

namespace Application\Controller;

use Application\Entity\AdminAccessible;

class PortfolioController extends FormHandlerController
{

    /**
     * {@inheritdoc}
     */
    protected function getEntityName()
    {
        return 'Portfolio Item';
    }

    /**
     * {@inheritdoc}
     */
    protected function getGroupedName()
    {
        return 'Portfolio';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClass()
    {
        return 'Application\Entity\PortfolioItem';
    }

    /**
     * {@inheritdoc}
     */
    protected function createForm(AdminAccessible $entity = null)
    {
        return $this->getFormFactory()
                    ->createBuilder('form', $entity, ['data_class' => $this->getEntityClass()])
                    ->add('title', 'text', ['required' => true])
                    ->add('file', 'file')
                    ->add('Add', 'submit')
                    ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    protected function getRoutes()
    {
        return [
            'list'   => 'route.portfolio',
            'single' => 'route.portfolio_item',
            'confirm_delete' => 'route.admin.confirm_delete_portfolio_item',
            'delete' => 'route.admin.delete_portfolio_item',
            'edit'   => 'route.admin.edit_portfolio_item',
            'create' => 'route.admin.portfolio_item'
        ];
    }
}