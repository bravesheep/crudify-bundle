<?php

namespace Bravesheep\CrudifyBundle\Definition\Form;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Form\OptionsProvider\OptionsInterface;

interface FormDefinitionInterface
{
    /**
     * @return string|null
     */
    public function getCreateForm();

    /**
     * @return string|null
     */
    public function getUpdateForm();

    /**
     * @return string|OptionsInterface
     */
    public function getOptionsProvider();

    /**
     * @return DefinitionInterface
     */
    public function getParent();

    /**
     * @param DefinitionInterface $definition
     */
    public function setParent(DefinitionInterface $definition);
}
