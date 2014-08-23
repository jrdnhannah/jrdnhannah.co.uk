<?php

namespace Application\Controller;

use Application\Exception\InvalidFormException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class FormHandlerController
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $em;

    /** @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $urlGenerator;

    /** @var \Symfony\Component\Form\FormFactoryInterface */
    private $form;

    /** @var string[] */
    protected $views = [];

    /** @var string[] */
    protected $routes = [];

    public function __construct(\Twig_Environment $twig, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator, FormFactoryInterface $form)
    {
        $this->twig = $twig;
        $this->em = $em;
        $this->urlGenerator = $urlGenerator;
        $this->form = $form;

        $this->resolveRoutesAndViews();
    }

    /**
     * @return string
     */
    abstract protected function getEntityName();

    /**
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * @param Object|null $entity
     * @return \Symfony\Component\Form\FormInterface
     * @throws \LogicException
     */
    abstract protected function createForm($entity = null);

    /**
     * @return string[]
     */
    abstract protected function getViews();

    /**
     * @return string[]
     */
    abstract protected function getRoutes();

    /**
     * @return string
     */
    public function showCollectionAction()
    {
        $list = $this->em->getRepository($this->getEntityClass())->findBy([], $this->getCollectionCriteria());

        return $this->twig->render($this->views['list'], ['list' => $list]);
    }

    /**
     * @param  object $entity
     * @return string
     */
    public function showItemAction($entity)
    {
        return $this->twig->render($this->views['single'], ['entity' => $entity]);
    }

    /**
     * @param Request $request
     * @return string|Response
     */
    public function createAction(Request $request)
    {
        $handler = function (Request $request, FormInterface $form) {
            $request->getSession()->getFlashBag()->add(
                'notice',
                sprintf('%s successfully created.', ucfirst($this->getEntityName()))
            );

            $this->em->persist($form->getData());
            $this->em->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate($this->routes['single'], ['entity' => $form->getData()->getId()])
            );
        };

        try {
            return $this->handleForm($request, $handler);
        } catch (InvalidFormException $e) {
            return $this->twig->render($this->views['create'], ['form' => $e->getForm()->createView()]);
        }

    }

    public function editAction(Request $request, $entity)
    {
        $handler = function (Request $request, FormInterface $form) {
            $request->getSession()->getFlashBag()->add(
                'notice',
                sprintf('%s successfully updated.', ucfirst($this->getEntityName()))
            );

            $this->em->flush();

            return new RedirectResponse(
                $this->urlGenerator->generate($this->routes['single'], ['entity' => $form->getData()->getId()])
            );
        };

        try {
            return $this->handleForm($request, $handler, $entity);
        } catch (InvalidFormException $e) {
            return $this->twig->render($this->views['create'], ['form' => $e->getForm()->createView()]);
        }
    }

    /**
     * @param  object $entity
     * @return string
     */
    public function confirmDeleteAction($entity)
    {
        return $this->twig->render($this->views['confirm_delete'], ['entity' => $entity]);
    }

    /**
     * @param Request          $request
     * @param AdminAccessible  $entity
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, AdminAccessible $entity)
    {
        $request->getSession()->getFlashBag()->add(
            'notice',
            sprintf('%s successfully deleted.', ucfirst($this->getEntityName()))
        );

        $this->em->remove($entity);
        $this->em->flush();

        return new RedirectResponse($this->urlGenerator->generate($this->routes['list']));
    }

    /**
     * @param Request $request
     * @param \Closure $handler
     * @param AdminAccessible|null $entity
     * @param Response $response
     * @return Response
     * @throws \Application\Exception\InvalidFormException
     */
    protected function handleForm(Request $request, \Closure $handler, AdminAccessible $entity = null, Response $response = null)
    {
        $form = $this->createForm($entity);
        $form->handleRequest($request);

        if (true === $form->isValid()) {
            if (($handlerResponse = $handler($request, $form)) instanceof Response) {
                return $handlerResponse;
            }

            return $response instanceof Response ?: new Response;
        }

        throw new InvalidFormException($form);
    }

    protected function configureViewsList(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['list', 'single', 'confirm_delete', 'create']);
    }

    protected function configureRoutesList(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['list', 'single']);
    }

    /**
     * @return array
     */
    protected function getCollectionCriteria()
    {
        return [];
    }

    /**
     * @return FormFactoryInterface
     */
    protected function getFormFactory()
    {
        return $this->form;
    }

    private function resolveRoutesAndViews()
    {
        $resolver = new OptionsResolver;
        $this->configureViewsList($resolver);
        $resolver->resolve($this->getViews());

        $resolver = new OptionsResolver;
        $this->configureRoutesList($resolver);
        $resolver->resolve($this->getRoutes());

        $this->views = $this->getViews();
        $this->routes = $this->getRoutes();
    }
}