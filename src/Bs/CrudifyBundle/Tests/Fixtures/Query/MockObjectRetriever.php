<?php

namespace Bs\CrudifyBundle\Tests\Fixtures\Query;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Query\ObjectRetrieverInterface;

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
