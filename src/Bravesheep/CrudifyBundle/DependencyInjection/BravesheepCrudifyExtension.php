<?php

namespace Bravesheep\CrudifyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
* This is the class that loads and manages your bundle configuration
*
* To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
*/
class BravesheepCrudifyExtension extends Extension
{
    /**
    * {@inheritDoc}
    */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('bravesheep_crudify.definitions', $config['mappings']);
        $container->setParameter('bravesheep_crudify.default_mapping', $config['default']);
        $container->setParameter('bravesheep_crudify.default_controller', $config['controller']);
        $container->setParameter('bravesheep_crudify.template_defaults', $config['templates']);
        $container->setParameter('bravesheep_crudify.security.default_access', $config['default_access']);
    }
}
