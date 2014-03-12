<?php

namespace Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Exception\QueryModifierNotFoundException;
use Bs\CrudifyBundle\Query\ModifierInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class QueryModifierResolver extends ContainerAware
{
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
                if ($refl->implementsInterface('Bs\CrudifyBundle\Query\ModifierInterface')) {
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
