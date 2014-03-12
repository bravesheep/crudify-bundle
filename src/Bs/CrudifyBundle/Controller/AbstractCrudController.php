<?php

namespace Bs\CrudifyBundle\Controller;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Event\CrudifyEvent;
use Bs\CrudifyBundle\Exception\CrudifyException;
use Bs\CrudifyBundle\Resolver\FormOptionsResolver;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class AbstractCrudController extends Controller implements CrudControllerInterface
{
    /**
     * @return Query
     */
    protected function createSelectQuery(IndexDefinitionInterface $definition)
    {
        return $this->get('bs_crudify.resolver.query')->resolveQuery($definition);
    }

    /**
     * @param Query               $builder
     * @param DefinitionInterface $definition
     * @param Request             $request
     * @return PaginationInterface
     */
    protected function getGrid(Query $builder, DefinitionInterface $definition, Request $request)
    {
        return $this->get('bs_crudify.resolver.grid')->getGrid($builder, $definition->getIndex(), $request);
    }

    /**
     * Retrieve the form for creating a new instance of an entity.
     * @param DefinitionInterface $definition
     * @return Form
     */
    protected function createCreateForm(DefinitionInterface $definition)
    {
        $type = $definition->getForm()->getCreateForm();
        $type = $this->get('bs_crudify.resolver.form')->resolve($type);

        $resolver = $this->get('bs_crudify.resolver.form_options');
        $options = $resolver->resolve($definition->getForm(), FormOptionsResolver::TYPE_CREATE, $this);
        return $this->createForm($type, null, $options);
    }

    /**
     * Retrieve the form for updating an entity.
     * @param DefinitionInterface $definition
     * @param object              $object
     * @return Form
     */
    protected function createUpdateForm(DefinitionInterface $definition, $object)
    {
        $type = $definition->getForm()->getUpdateForm();
        $type = $this->get('bs_crudify.resolver.form')->resolve($type);

        $resolver = $this->get('bs_crudify.resolver.form_options');
        $options = $resolver->resolve($definition->getForm(), FormOptionsResolver::TYPE_UPDATE, $this, $object);
        return $this->createForm($type, $object, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createDeleteForm(DefinitionInterface $definition, $object)
    {
        $builder = $this->createFormBuilder([], [
            'action' => $this->getLink('update', $definition, $object),
            'method' => 'DELETE',
        ]);

        return $builder->getForm();
    }

    /**
     * @param string              $eventName
     * @param object              $object
     * @param DefinitionInterface $definition
     */
    protected function triggerEvent($eventName, $object, DefinitionInterface $definition)
    {
        $event = new CrudifyEvent($object, $definition);
        $this->get('event_dispatcher')->dispatch($eventName, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function getLink($action, DefinitionInterface $definition, $object = null)
    {
        return $this->get('bs_crudify.resolver.link')->getLinkForAction($action, $definition, $object);
    }

    /**
     * @param DefinitionInterface $definition
     * @param object              $object
     * @param Request             $request
     * @return Response
     */
    protected function determineSuccessResponse(DefinitionInterface $definition, $object, Request $request)
    {
        $action = $request->request->get('action', 'index');
        if ($action === 'edit') {
            return $this->redirect($this->getLink('edit', $definition, $object));
        } elseif ($action === 'index') {
            return $this->redirect($this->getLink('index', $definition));
        } else {
            throw new CrudifyException("Invalid action '{$action}' was submitted");
        }
    }

    /**
     * @param string $what
     * @param object $object
     * @throws AccessDeniedHttpException
     */
    protected function isGranted($what, $object)
    {
        if (!$this->get('security.context')->isGranted($what, $object)) {
            throw new AccessDeniedHttpException("Not allowed to {$what} on object");
        }
    }

    /**
     * @param DefinitionInterface $definition
     * @param int                 $id
     */
    protected function retrieveObject(DefinitionInterface $definition, $id)
    {
        $retriever = $this->get('bs_crudify.resolver.object_retriever')->resolve($definition->getObjectRetriever());
        return $retriever->retrieve($definition, $id);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}