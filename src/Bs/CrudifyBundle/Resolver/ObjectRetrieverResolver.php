<?php

namespace Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Exception\ObjectRetrieverNotFoundException;
use Bs\CrudifyBundle\Query\ObjectRetrieverInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class ObjectRetrieverResolver extends ContainerAware
{
    /**
     * @param string|ObjectRetrieverInterface $retriever
     * @return object
     * @throws ObjectRetrieverNotFoundException
     */
    public function resolve($retriever)
    {
        if (is_string($retriever)) {
            if ($this->container->has($retriever)) {
                $retriever = $this->container->get($retriever);
            } elseif (class_exists($retriever, true)) {
                $refl = new \ReflectionClass($retriever);
                if ($refl->implementsInterface('Bs\CrudifyBundle\Query\ObjectRetrieverInterface')) {
                    $constructor = $refl->getConstructor();
                    if (null === $constructor || $constructor->getNumberOfRequiredParameters() === 0) {
                        $retriever = $refl->newInstance();
                    }
                }
            }
        }

        if (!($retriever instanceof ObjectRetrieverInterface)) {
            throw new ObjectRetrieverNotFoundException("Retriever could not be found");
        }
        return $retriever;
    }
}
