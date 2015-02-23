<?php

namespace Bravesheep\CrudifyBundle\Controller;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CrudifyController implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param $mapping
     * @return DefinitionInterface
     * @throws NotFoundHttpException
     */
    private function getDefinition($mapping)
    {
        $registry = $this->container->get('bravesheep_crudify.definition.registry');
        if (!$registry->hasDefinition($mapping)) {
            throw new NotFoundHttpException();
        }

        return $registry->getDefinition($mapping);
    }

    /**
     * @param DefinitionInterface $definition
     * @return CrudControllerInterface
     */
    private function getController(DefinitionInterface $definition)
    {
        $controller = $definition->getController();
        return $this->container->get('bravesheep_crudify.resolver.controller')->resolve($controller);
    }

    /**
     * Check if the user has access to the specified definition for the given attribute.
     * @param string              $attribute
     * @param DefinitionInterface $definition
     * @throws AccessDeniedException
     */
    private function isGranted($attribute, DefinitionInterface $definition)
    {
        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted($attribute, $definition)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @return Response
     */
    public function indexAction(Request $request, $mapping)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_INDEX', $definition);
        $controller = $this->getController($definition);
        return $controller->indexAction($definition, $request);
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @return Response
     */
    public function newAction(Request $request, $mapping)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_CREATE', $definition);
        $controller = $this->getController($definition);
        return $controller->newAction($definition, $request);
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @return Response
     */
    public function createAction(Request $request, $mapping)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_CREATE', $definition);
        $controller = $this->getController($definition);
        return $controller->createAction($definition, $request);
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @param string  $id
     * @return Response
     */
    public function editAction(Request $request, $mapping, $id)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_UPDATE', $definition);
        $controller = $this->getController($definition);
        return $controller->editAction($definition, $request, (int) $id);
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @param string  $id
     * @return Response
     */
    public function updateAction(Request $request, $mapping, $id)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_UPDATE', $definition);
        $controller = $this->getController($definition);
        return $controller->updateAction($definition, $request, (int) $id);
    }

    /**
     * @param Request $request
     * @param string  $mapping
     * @param string  $id
     * @return Response
     */
    public function deleteAction(Request $request, $mapping, $id)
    {
        $definition = $this->getDefinition($mapping);
        $request->attributes->set('definition', $definition);
        $this->isGranted('CRUDIFY_DELETE', $definition);
        $controller = $this->getController($definition);
        return $controller->deleteAction($definition, $request, (int) $id);
    }
}
