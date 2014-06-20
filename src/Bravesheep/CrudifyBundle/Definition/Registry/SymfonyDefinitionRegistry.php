<?php

namespace Bravesheep\CrudifyBundle\Definition\Registry;

use Bravesheep\CrudifyBundle\Definition\Loader\DIDefinitionLoader;

class SymfonyDefinitionRegistry extends DefinitionRegistry
{
    /**
     * @var DIDefinitionLoader
     */
    private $loader;

    public function __construct(DIDefinitionLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Add mappings from the DI config to the definition registry.
     * @param array $mappings
     */
    public function addMappings(array $mappings)
    {
        $this->loader->loadAll($mappings, $this);
    }
}
