<?php

namespace Bravesheep\CrudifyBundle\Definition;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Template\TemplateDefinitionInterface;
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
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $entityTitle;

    /**
     * @var string
     */
    private $objectRetriever;

    /**
     * @var TemplateDefinitionInterface
     */
    private $templates;

    /**
     * @var string
     */
    private $translationDomain;

    /**
     * @var array
     */
    private $extras;

    public function __construct($entity, EntityManager $entityManager)
    {
        $this->flags = [];
        $this->setEntity($entity);
        $this->setEntityManager($entityManager);
        $this->setTranslationDomain('messages');
        $this->extras = [];
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

    /**
     * @param TemplateDefinitionInterface $templates
     * @return $this
     */
    public function setTemplates(TemplateDefinitionInterface $templates)
    {
        $this->templates = $templates;
        $templates->setParent($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }

    /**
     * @param string $translationDomain
     * @return $this
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
        return $this;
    }

    /**
     * Set the list of extra configured keys.
     * @param array $extras
     * @return $this
     */
    public function setExtras(array $extras)
    {
        $this->extras = $extras;
        return $this;
    }

    /**
     * Retrieve extra configured keys.
     * @return array
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Set an extra configuration key.
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setExtra($key, $value)
    {
        $this->extras[$key] = $value;
        return $this;
    }

    /**
     * Retrieve an extra configuration setting.
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function getExtra($key, $default = null)
    {
        if (isset($this->extras[$key])) {
            return $this->extras[$key];
        } else {
            return $default;
        }
    }
}
