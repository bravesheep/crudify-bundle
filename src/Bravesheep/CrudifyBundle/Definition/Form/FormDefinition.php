<?php

namespace Bravesheep\CrudifyBundle\Definition\Form;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Form\OptionsProvider\OptionsInterface;

class FormDefinition implements FormDefinitionInterface
{
    /**
     * @var string|null
     */
    private $createForm;

    /**
     * @var string|null
     */
    private $updateForm;

    /**
     * @var DefinitionInterface
     */
    private $parent;

    /**
     * @var string|OptionsInterface
     */
    private $optionsProvider;

    public function __construct($createForm, $updateForm)
    {
        $this->createForm = $createForm;
        $this->updateForm = $updateForm;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateForm()
    {
        return $this->createForm;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdateForm()
    {
        return $this->updateForm;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(DefinitionInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param OptionsInterface|string $optionsProvider
     * @return $this
     */
    public function setOptionsProvider($optionsProvider)
    {
        $this->optionsProvider = $optionsProvider;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptionsProvider()
    {
        return $this->optionsProvider;
    }
}
