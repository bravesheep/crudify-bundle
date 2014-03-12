<?php

namespace Bs\CrudifyBundle\Definition\Index\Builder\Registry;

use Bs\CrudifyBundle\Definition\Index\Builder\BuilderInterface;
use Bs\CrudifyBundle\Exception\BuilderNotFoundException;

class BuilderRegistry
{
    /**
     * @var BuilderInterface[]
     */
    private $builders;

    public function __construct()
    {
        $this->builders = [];
    }

    /**
     * Add a new builder to the registry under the given alias.
     * @param BuilderInterface $builder
     * @param string           $alias
     */
    public function addBuilder(BuilderInterface $builder, $alias)
    {
        $this->builders[$alias] = $builder;
    }

    /**
     * Return whether or not a builder by the given name exists.
     * @param string $name
     * @return bool
     */
    public function hasBuilder($name)
    {
        return isset($this->builders[$name]);
    }

    /**
     * Retrieve a builder by name.
     * @param string $name
     * @return BuilderInterface
     * @throws BuilderNotFoundException
     */
    public function getBuilder($name)
    {
        if (!$this->hasBuilder($name)) {
            throw new BuilderNotFoundException("Builder with name '{$name}' was not found");
        }
        return $this->builders[$name];
    }

    /**
     * Retrieve the names of the defined builders
     * @return string[]
     */
    public function getDefinedBuilders()
    {
        return array_keys($this->builders);
    }
}
