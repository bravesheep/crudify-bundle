<?php

namespace Bs\CrudifyBundle\Query;

use Bs\CrudifyBundle\Definition\DefinitionInterface;

interface ObjectRetrieverInterface
{
    /**
     * @param DefinitionInterface $definition
     * @param int                 $id
     * @return object
     */
    public function retrieve(DefinitionInterface $definition, $id);
}
