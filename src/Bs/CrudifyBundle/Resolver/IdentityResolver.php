<?php

namespace Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Exception\UnsupportedEntityException;

class IdentityResolver
{
    /**
     * @param object $object
     * @return string
     * @throws UnsupportedEntityException
     */
    public function getIdentityColumn(DefinitionInterface $definition)
    {
        $metadata = $definition->getEntityManager()->getClassMetadata($definition->getEntityName());
        $names = $metadata->getIdentifierFieldNames();
        if (count($names) !== 1) {
            throw new UnsupportedEntityException(
                "Entity '{$metadata->getName()}' must have exactly one identifier column"
            );
        }
        return $names[0];
    }

    /**
     * @param object $object
     * @return mixed
     * @throws UnsupportedEntityException
     */
    public function getId(DefinitionInterface $definition, $object)
    {
        $metadata = $definition->getEntityManager()->getClassMetadata($definition->getEntityName());
        $identity = $metadata->getIdentifierValues($object);
        if (count($identity) !== 1) {
            throw new UnsupportedEntityException(
                "Entity '{$metadata->getName()}' must have exactly one identifier column"
            );
        }
        reset($identity);
        return current($identity);
    }
}
