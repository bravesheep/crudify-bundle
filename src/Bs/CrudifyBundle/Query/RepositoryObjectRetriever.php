<?php

namespace Bs\CrudifyBundle\Query;

use Bs\CrudifyBundle\Definition\DefinitionInterface;

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
