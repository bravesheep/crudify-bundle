<?php

namespace Bravesheep\CrudifyBundle\DependencyInjection;

use Bravesheep\CrudifyBundle\Exception\InvalidDefinitionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CrudifyCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->processIndexDefinitionFactoryTags($container);
        $this->processDefinitionTags($container);
    }

    /**
     * Add index definition factories to the registry for them.
     * @param ContainerBuilder $container
     * @throws InvalidDefinitionException
     */
    private function processIndexDefinitionFactoryTags(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('bs_crudify.definition.index.builder_registry')) {
            return;
        }

        $definition = $container->getDefinition('bs_crudify.definition.index.builder_registry');
        $taggedServices = $container->findTaggedServiceIds('bs_crudify.index_builder');
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                if (!isset($attributes['alias'])) {
                    throw new InvalidDefinitionException(
                        "Attribute 'alias' for tag 'bs_crudify.index_builder' not found on service '{$id}'"
                    );
                }
                $definition->addMethodCall('addBuilder', [new Reference($id), $attributes['alias']]);
            }
        }
    }

    /**
     * Add definitions defined via dependency injection (you'll generally do this via the crudify config instead).
     * @param ContainerBuilder $container
     * @throws InvalidDefinitionException
     */
    private function processDefinitionTags(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('bs_crudify.definition.registry')) {
            return;
        }

        $definition = $container->getDefinition('bs_crudify.definition.registry');
        $taggedServices = $container->findTaggedServiceIds('bs_crudify.definition');
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                if (!isset($attributes['alias'])) {
                    throw new InvalidDefinitionException(
                        "Attribute 'alias' for tag 'bs_crudify.definition' not found on service {$id}"
                    );
                }
                $definition->addMethodCall('addDefinition', [new Reference($id), $attributes['alias']]);
            }
        }
    }
}
