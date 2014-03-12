<?php

namespace Bs\CrudifyBundle\Form\OptionsProvider;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\DefinitionInterface;

interface OptionsInterface
{
    public function getCreateOptions(CrudControllerInterface $controller, DefinitionInterface $definition);

    public function getUpdateOptions(CrudControllerInterface $controller, DefinitionInterface $definition, $object);
}
