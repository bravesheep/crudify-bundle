<?php

namespace Bs\CrudifyBundle\Controller;

use Doctrine\ORM\PersistentCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tg\OkoaBundle\Controller\ControllerExtras;

class AdminController extends Controller
{

    use ControllerExtras;

    protected $entity;
    protected $table;
    protected $definition;
    protected $instance;

    /**
     * @Route("/", name="admin_index")
     */
    public function indexAction()
    {
        $config = $this->container->getParameter('admin');
        $this->entity = $config['default'];
        return $this->redirect($this->getUrl('index'));
    }

    /**
     * @Route("/list/{entity}", name="admin_list")
     * @Template()
     */
    public function listAction($entity)
    {
        $class = $this->setEntity($entity);

        // default query builder
        $qb = $class::qb($this->table);

        // default sort settings
        if (isset($this->definition['sort'])) {
            list($sort, $direction) = $this->definition['sort'];
        } else {
            $sort = $this->table . '.' . $this->definition['index'][0]['name'];
            $direction = 'asc';
        }

        // get sort parameters
        $sort = $this->request->get('sort', $sort);
        $direction = $this->request->get('direction', $direction);

        // join sort associations
        list($join, $field) = explode('.', $sort);
        if ($join !== $this->table) {
            $qb->leftJoin($this->table . '.' . $join, $join);
        }
        $qb->orderBy($sort, $direction);

        //product pagination
        $page = $this->request->get('page', 1);
        $pagination = $this->knp_paginator->paginate($qb, $page, 20);

        // default sort
        $pagination->setParam('sort', $sort);
        $pagination->setParam('direction', $direction);

        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Route("/add/{entity}", name="admin_add")
     * @Template()
     */
    public function addAction($entity)
    {
        $class = $this->setEntity($entity);
        $this->instance = new $class();

        $form = $this->buildForm();

        if ($form->isValid()) {
            $this->em->persist($this->instance);
            $this->em->flush();

            $this->setMessage('saved');

            $action = $this->request->get('action', 'index');
            return $this->redirect($this->getUrl($action));

        } elseif ($this->request->getMethod() === 'POST') {
            $this->setMessage('not saved', 'error');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/edit/{entity}/{id}", name="admin_edit")
     * @Template()
     */
    public function editAction($entity, $id)
    {
        $class = $this->setEntity($entity);
        $this->instance = $class::find($id);

        if (!$this->instance) {
            throw new HttpException(404);
        }

        $form = $this->buildForm();

        if ($form->isValid()) {
            $this->em->persist($this->instance);
            $this->em->flush();

            $this->setMessage('saved');

            $action = $this->request->get('action', 'index');
            return $this->redirect($this->getUrl($action));

        } elseif ($this->request->getMethod() === 'POST') {
            $this->setMessage('not saved', 'error');
        }

        $deleteForm = $this->createFormBuilder()->getForm();

        return [
            'form' => $form->createView(),
            'instance' => $this->instance,
            'delete_form' => $deleteForm->createView()
        ];
    }

    /**
     * Deletes a entity.
     *
     * @Route("/delete/{entity}/{id}", name="admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction($entity, $id)
    {
        $class = $this->setEntity($entity);

        // create form
        $this->instance = $class::find($id);

        if (!$this->instance) {
            throw new HttpException(404);
        }

        $form = $this->createFormBuilder()->getForm()->bind($this->request);

        if ($form->isValid()) {

            $mappings = $this->em->getClassMetadata($class)->getAssociationMappings();
            foreach ($mappings as $mapping) {
                if (!$mapping['isOwningSide'] && !$mapping['isCascadeRemove']) {
                    // check for associated entities
                    $values = $this->instance->{$mapping['fieldName']}();
                    if ($values instanceof PersistentCollection && count($values) > 0) {
                        // format error message
                        $name = substr(strrchr($mapping['targetEntity'], '\\'), 1);
                        $name = $this->translator->trans($name);
                        $message = $this->translator->trans(
                            'not deleted, %num% %association% associations present', [
                                '%num%' => count($values),
                                '%association%' => strtolower($name)
                            ]
                        );
                        $this->setMessage($message, 'error');
                        // create route to edit page
                        $url = $this->generateUrl('admin_edit', [
                            'entity' => $this->entity,
                            'id' => $id
                        ]);
                        // redirect to the edit page
                        return $this->redirect($url);
                    }
                }
            }

            $this->em->remove($this->instance);
            $this->em->flush();
            $this->setMessage('deleted', 'notice');
        }

        return $this->redirect($this->getUrl());
    }

    protected function setMessage($message, $type = 'success')
    {
        $message = $this->translator->trans($message);
        $message = sprintf('%s "%s" %s', $this->entity, $this->instance, $message);
        $this->session->getFlashBag()->set($type, $message);
    }

    protected function setEntity($entity)
    {
        $this->entity = $entity;

        $config = $this->container->getParameter('admin');
        $this->entities = $config['entities'];

        if (!in_array($this->entity, array_keys($this->entities))) {
            throw new HttpException(404);
        }

        $class = $this->entities[$this->entity]['ns'];
        $className = explode('\\', $class);
        $className = $className[count($className) - 1];
        $this->table = strtolower($className[0]) . substr($className, 1);

        foreach ($this->entities[$this->entity]['index'] as &$field) {
            if (strstr($field, '.') === false) {
                $field = ['table' => $this->table, 'name' => $field];
            } else {
                list($table, $name) = explode('.', $field, 2);
                $field = ['table' => $table, 'name' => $name];
            }
        }

        $this->definition = $this->entities[$this->entity];

        $this->twig->addGlobal('layout', $config['layout']);
        $this->twig->addGlobal('table', $this->table);
        $this->twig->addGlobal('entity', $this->entity);
        $this->twig->addGlobal('entities', $this->entities);

        return $class;
    }

    protected function getUrl($name = 'index')
    {
        if ($name === 'index') {
            return $this->generateUrl('admin_list', [
                'entity' => $this->entity
            ]);
        } else if ($name === 'edit' && $this->instance) {
            return $this->generateUrl('admin_edit', [
                'entity' => $this->entity,
                'id' => $this->instance->getId()
            ]);
        }
    }

    protected function buildForm()
    {
        $definition = $this->definition['form'];

        if (is_array($definition)) {
            $builder = $this->createFormBuilder($this->instance);
            foreach ($definition as $field) {
                $builder->add($field);
            }
            $form = $builder->getForm();
        } else if (class_exists($definition)) {
            $form = $this->createForm(new $definition(), $this->instance);
        } else {
            throw new HttpException(404);
        }

        $form->handleRequest($this->request);

        return $form;
    }

}
