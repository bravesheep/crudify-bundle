<?php

namespace Bravesheep\CrudifyBundle\Form\OptionsProvider;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

interface OptionsInterface
{
    public function getCreateOptions(CrudControllerInterface $controller, DefinitionInterface $definition);

    public function getUpdateOptions(CrudControllerInterface $controller, DefinitionInterface $definition, $object);
}
