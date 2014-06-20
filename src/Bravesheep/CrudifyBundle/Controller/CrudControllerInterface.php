<?php

namespace Bravesheep\CrudifyBundle\Controller;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface CrudControllerInterface extends ContainerAwareInterface
{
    /**
     * Show a list of available instances for an entity.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @return Response
     */
    public function indexAction(DefinitionInterface $definition, Request $request);

    /**
     * Show a form for creating a new entity instance.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @return Response
     */
    public function newAction(DefinitionInterface $definition, Request $request);

    /**
     * Create a new entity instance in the database.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @return Response
     */
    public function createAction(DefinitionInterface $definition, Request $request);

    /**
     * Show the edit form for an entity instance.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @param int                 $id
     * @return Response
     */
    public function editAction(DefinitionInterface $definition, Request $request, $id);

    /**
     * Update an entity instance.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @param int                 $id
     * @return Response
     */
    public function updateAction(DefinitionInterface $definition, Request $request, $id);

    /**
     * Delete an entity instance.
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @param int                 $id
     * @return Response
     */
    public function deleteAction(DefinitionInterface $definition, Request $request, $id);

    /**
     * Retrieve the form for deleting an entity.
     * @param DefinitionInterface $definition
     * @param object              $object
     * @return Form
     */
    public function createDeleteForm(DefinitionInterface $definition, $object);

    /**
     * @return ContainerInterface
     */
    public function getContainer();

    /**
     * Retrieve the url for the given action.
     * @param string              $action
     * @param DefinitionInterface $definition
     * @param object              $object
     * @return string
     */
    public function getLink($action, DefinitionInterface $definition, $object = null);
}
