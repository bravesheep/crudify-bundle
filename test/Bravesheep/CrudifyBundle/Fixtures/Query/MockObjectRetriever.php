<?php

namespace Bravesheep\CrudifyBundle\Fixtures\Query;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Query\ObjectRetrieverInterface;

class MockObjectRetriever implements ObjectRetrieverInterface
{
    /**
     * {@inheritdoc}
     */
    public function retrieve(DefinitionInterface $definition, $id)
    {
        return null;
    }
}
