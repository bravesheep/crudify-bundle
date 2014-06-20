<?php

namespace Bravesheep\CrudifyBundle\Query;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

interface ObjectRetrieverInterface
{
    /**
     * @param DefinitionInterface $definition
     * @param int                 $id
     * @return object
     */
    public function retrieve(DefinitionInterface $definition, $id);
}
