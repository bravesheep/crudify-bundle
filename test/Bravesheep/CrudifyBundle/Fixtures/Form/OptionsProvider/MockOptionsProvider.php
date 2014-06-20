<?php

namespace Bravesheep\CrudifyBundle\Fixtures\Form\OptionsProvider;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Form\OptionsProvider\OptionsInterface;

class MockOptionsProvider implements OptionsInterface
{
    public function getCreateOptions(CrudControllerInterface $controller, DefinitionInterface $definition)
    {
        return ['create' => true];
    }

    public function getUpdateOptions(CrudControllerInterface $controller, DefinitionInterface $definition, $object)
    {
        return ['update' => true];
    }
}
