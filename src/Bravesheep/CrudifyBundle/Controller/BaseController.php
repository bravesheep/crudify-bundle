<?php

namespace Bravesheep\CrudifyBundle\Controller;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Event\CrudifyEvents;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractCrudController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(DefinitionInterface $definition, Request $request)
    {
        $query = $this->createSelectQuery($definition->getIndex());
        $grid = $this->getGrid($query, $definition, $request);

        return $this->render($definition->getTemplates()->getIndex(), [
            'definition' => $definition,
            'objects' => $grid,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function newAction(DefinitionInterface $definition, Request $request)
    {
        $form = $this->createCreateForm($definition);
        $object = $form->getData();

        return $this->render($definition->getTemplates()->getNew(), [
            'definition' => $definition,
            'form' => $form->createView(),
            'object' => $object,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function createAction(DefinitionInterface $definition, Request $request)
    {
        $form = $this->createCreateForm($definition);
        $form->handleRequest($request);
        $object = $form->getData();

        if ($form->isValid()) {
            $this->triggerEvent(CrudifyEvents::BEFORE_CREATE, $object, $definition);
            $manager = $definition->getEntityManager();
            $manager->persist($object);
            $manager->flush();
            $this->triggerEvent(CrudifyEvents::CREATE, $object, $definition);
            $this->addTranslatedFlash($definition, 'success', 'The object was created.');
            return $this->determineSuccessResponse($definition, $object, $request);
        }

        $this->addTranslatedFlash($definition, 'error', 'There were errors on the form.');
        return $this->render($definition->getTemplates()->getNew(), [
            'definition' => $definition,
            'form' => $form->createView(),
            'object' => $object,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function editAction(DefinitionInterface $definition, Request $request, $id)
    {
        $object = $this->retrieveObject($definition, $id);
        if (null === $object) {
            throw $this->createNotFoundException();
        }

        // store referer to redirect back after save
        if (!$this->get('session')->remove('ignore_referer')) {
            $this->get('session')->set('edit_referer', $request->headers->get('referer'));
        }

        $form = $this->createUpdateForm($definition, $object);
        return $this->render($definition->getTemplates()->getEdit(), [
            'definition' => $definition,
            'form' => $form->createView(),
            'object' => $object,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateAction(DefinitionInterface $definition, Request $request, $id)
    {
        $object = $this->retrieveObject($definition, $id);
        if (null === $object) {
            throw $this->createNotFoundException();
        }

        $form = $this->createUpdateForm($definition, $object);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->triggerEvent(CrudifyEvents::BEFORE_UPDATE, $object, $definition);
            $manager = $definition->getEntityManager();
            $manager->flush();
            $this->triggerEvent(CrudifyEvents::UPDATE, $object, $definition);
            $this->addTranslatedFlash($definition, 'success', 'The object was updated.');
            return $this->determineSuccessResponse($definition, $object, $request);
        }

        $this->addTranslatedFlash($definition, 'error', 'There were errors on the form.');
        return $this->render($definition->getTemplates()->getEdit(), [
            'definition' => $definition,
            'form' => $form->createView(),
            'object' => $object,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAction(DefinitionInterface $definition, Request $request, $id)
    {
        $object = $this->retrieveObject($definition, $id);
        if (null === $object) {
            throw $this->createNotFoundException();
        }

        $form = $this->createDeleteForm($definition, $object);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->triggerEvent(CrudifyEvents::BEFORE_DELETE, $object, $definition);
            $manager = $definition->getEntityManager();
            $manager->remove($object);

            try {
                $manager->flush();
                $this->triggerEvent(CrudifyEvents::DELETE, $object, $definition);
                $this->addTranslatedFlash($definition, 'success', 'The object was removed.');
            } catch (DBALException $e) {
                $this->addTranslatedFlash($definition, 'error', 'An error occured when trying to remove the object.');
            }
        } else {
            $this->addTranslatedFlash($definition, 'error', 'An error occured when trying to remove the object.');
        }

        return $this->redirect($this->generateUrl('bravesheep_crudify.index', [
            'mapping' => $definition->getName(),
        ]));
    }
}
