<?php

namespace Bs\CrudifyBundle\Tests\Fixtures\Form\OptionsProvider;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Form\OptionsProvider\OptionsInterface;

class MockOptionsProvider implements OptionsInterface
{
    public function getCreateOptions(CrudControllerInterface $controller, DefinitionInterface $definition)
    {
        return [];
    }

    public function getUpdateOptions(CrudControllerInterface $controller, DefinitionInterface $definition, $object)
    {
        return [];
    }
}
