<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Exception\ObjectRetrieverNotFoundException;
use Bravesheep\CrudifyBundle\Query\ObjectRetrieverInterface;
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
                if ($refl->implementsInterface('Bravesheep\CrudifyBundle\Query\ObjectRetrieverInterface')) {
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
