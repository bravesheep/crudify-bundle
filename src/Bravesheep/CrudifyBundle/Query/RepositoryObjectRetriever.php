<?php

namespace Bravesheep\CrudifyBundle\Query;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

class RepositoryObjectRetriever implements ObjectRetrieverInterface
{
    /**
     * {@inheritdoc}
     */
    public function retrieve(DefinitionInterface $definition, $id)
    {
        $repo = $definition->getEntityRepository();
        return $repo->find($id);
    }
}
