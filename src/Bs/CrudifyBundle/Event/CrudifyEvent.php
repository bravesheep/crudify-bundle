<?php

namespace Bs\CrudifyBundle\Event;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Symfony\Component\EventDispatcher\Event;

class CrudifyEvent extends Event
{
    /**
     * @var object
     */
    protected $object;

    /**
     * @var DefinitionInterface
     */
    protected $definition;

    /**
     * @param object              $object
     * @param DefinitionInterface $definition
     */
    public function __construct($object, DefinitionInterface $definition)
    {
        $this->object = $object;
        $this->definition = $definition;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return DefinitionInterface
     */
    public function getDefinition()
    {
        return $this->definition;
    }


}
