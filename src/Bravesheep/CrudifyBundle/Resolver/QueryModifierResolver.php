<?php

namespace Bravesheep\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Exception\QueryModifierNotFoundException;
use Bravesheep\CrudifyBundle\Query\ModifierInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class QueryModifierResolver
{
    use ContainerAwareTrait;

    /**
     * @param string|ModifierInterface $modifier
     * @return ModifierInterface
     * @throws QueryModifierNotFoundException
     */
    public function resolve($modifier)
    {
        if (is_string($modifier)) {
            if ($this->container->has($modifier)) {
                $modifier = $this->container->get($modifier);
            } elseif (class_exists($modifier, true)) {
                $refl = new \ReflectionClass($modifier);
                if ($refl->implementsInterface('Bravesheep\CrudifyBundle\Query\ModifierInterface')) {
                    $constructor = $refl->getConstructor();
                    if (null === $constructor || $constructor->getNumberOfRequiredParameters() === 0) {
                        $modifier = $refl->newInstance();
                    }
                }
            }
        }

        if (!($modifier instanceof ModifierInterface)) {
            throw new QueryModifierNotFoundException("No such query modifier");
        }
        return $modifier;
    }
}
