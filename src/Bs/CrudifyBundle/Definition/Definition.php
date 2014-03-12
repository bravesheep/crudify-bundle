<?php

namespace Bs\CrudifyBundle\Definition;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Doctrine\ORM\EntityManager;

class Definition implements DefinitionInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var IndexDefinitionInterface
     */
    private $index;

    /**
     * @var FormDefinitionInterface
     */
    private $form;

    /**
     * @var bool[]
     */
    private $flags;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var CrudControllerInterface|string|null
     */
    private $controller;

    /**
     * @var string
     */
    private $indexTemplate;

    /**
     * @var string
     */
    private $newTemplate;

    /**
     * @var string
     */
    private $editTemplate;

    /**
     * @var string
     */
    private $formThemeTemplate;

    /**
     * @var string
     */
    private $paginationTemplate;

    /**
     * @var string
     */
    private $sortableTemplate;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var string
     */
    private $entityTitle;

    /**
     * @var string
     */
    private $objectRetriever;

    public function __construct($entity, $entityManager)
    {
        $this->flags = [];
        $this->setEntity($entity);
        $this->setEntityManager($entityManager);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $entity
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param bool[] $flags
     * @return $this
     */
    public function setFlags(array $flags)
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * @param FormDefinitionInterface $form
     * @return $this
     */
    public function setForm(FormDefinitionInterface $form)
    {
        $this->form = $form;
        $this->form->setParent($this);
        return $this;
    }

    /**
     * @param IndexDefinitionInterface $index
     * @return $this
     */
    public function setIndex(IndexDefinitionInterface $index)
    {
        $this->index = $index;
        $this->index->setParent($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName()
    {
        return $this->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function withCreate()
    {
        return isset($this->flags['create']) && $this->flags['create'] === true;
    }

    /**
     * {@inheritdoc}
     */
    public function withUpdate()
    {
        return isset($this->flags['update']) && $this->flags['update'] === true;
    }

    /**
     * {@inheritdoc}
     */
    public function withDelete()
    {
        return isset($this->flags['delete']) && $this->flags['delete'] === true;
    }

    /**
     * @param string|CrudControllerInterface|null $controller
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $editTemplate
     * @return $this
     */
    public function setEditTemplate($editTemplate)
    {
        $this->editTemplate = $editTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEditTemplate()
    {
        return $this->editTemplate;
    }

    /**
     * @param string $indexTemplate
     * @return $this
     */
    public function setIndexTemplate($indexTemplate)
    {
        $this->indexTemplate = $indexTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexTemplate()
    {
        return $this->indexTemplate;
    }

    /**
     * @param string $newTemplate
     * @return $this
     */
    public function setNewTemplate($newTemplate)
    {
        $this->newTemplate = $newTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewTemplate()
    {
        return $this->newTemplate;
    }

    /**
     * @param string $formThemeTemplate
     * @return $this
     */
    public function setFormThemeTemplate($formThemeTemplate)
    {
        $this->formThemeTemplate = $formThemeTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormThemeTemplate()
    {
        return $this->formThemeTemplate;
    }

    /**
     * @param string $paginationTemplate
     * @return $this
     */
    public function setPaginationTemplate($paginationTemplate)
    {
        $this->paginationTemplate = $paginationTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginationTemplate()
    {
        return $this->paginationTemplate;
    }

    /**
     * @param string $sortableTemplate
     * @return $this
     */
    public function setSortableTemplate($sortableTemplate)
    {
        $this->sortableTemplate = $sortableTemplate;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortableTemplate()
    {
        return $this->sortableTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityRepository()
    {
        return $this->getEntityManager()->getRepository($this->getEntityName());
    }

    /**
     * @param EntityManager $entityManager
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $entityTitle
     * @return $this
     */
    public function setEntityTitle($entityTitle)
    {
        $this->entityTitle = $entityTitle;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityTitle()
    {
        return $this->entityTitle;
    }

    /**
     * @param string $objectRetriever
     * @return $this
     */
    public function setObjectRetriever($objectRetriever)
    {
        $this->objectRetriever = $objectRetriever;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectRetriever()
    {
        return $this->objectRetriever;
    }
}
