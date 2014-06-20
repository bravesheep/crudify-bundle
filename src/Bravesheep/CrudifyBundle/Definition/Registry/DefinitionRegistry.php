<?php

namespace Bravesheep\CrudifyBundle\Definition\Registry;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Exception\DefinitionNotFoundException;

class DefinitionRegistry
{
    /**
     * @var DefinitionInterface[]
     */
    private $definitions;

    public function __construct()
    {
        $this->definitions = [];
    }

    /**
     * Add a definition to the list of definitions.
     * @param DefinitionInterface $definition
     * @param string              $alias
     */
    public function addDefinition(DefinitionInterface $definition, $alias)
    {
        $this->definitions[$alias] = $definition;
    }

    /**
     * Return whether or not a definition with the given name exists.
     * @param string $name
     * @return bool
     */
    public function hasDefinition($name)
    {
        return isset($this->definitions[$name]);
    }

    /**
     * Retrieve a definition with the specified name.
     * @param string $name
     * @return DefinitionInterface
     * @throws DefinitionNotFoundException
     */
    public function getDefinition($name)
    {
        if (!$this->hasDefinition($name)) {
            throw new DefinitionNotFoundException("Definition with name '{$name}' was not found");
        }
        return $this->definitions[$name];
    }

    /**
     * Return the defined definitions.
     * @return string[]
     */
    public function getDefinedNames()
    {
        return array_keys($this->definitions);
    }

    /**
     * @return DefinitionInterface[]
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}
