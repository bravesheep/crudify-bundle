<?php

namespace Bs\CrudifyBundle\Definition\Form;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Form\OptionsProvider\OptionsInterface;

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
