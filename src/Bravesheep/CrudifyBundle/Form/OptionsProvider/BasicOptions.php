<?php

namespace Bravesheep\CrudifyBundle\Form\OptionsProvider;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

class BasicOptions implements OptionsInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCreateOptions(CrudControllerInterface $controller, DefinitionInterface $definition)
    {
        return [
            'method' => 'POST',
            'action' => $controller->getLink('create', $definition),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdateOptions(CrudControllerInterface $controller, DefinitionInterface $definition, $object)
    {
        return [
            'method' => 'PUT',
            'action' => $controller->getLink('update', $definition, $object),
        ];
    }
}
