<?php

namespace Bravesheep\CrudifyBundle;

use Bravesheep\CrudifyBundle\DependencyInjection\CrudifyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BravesheepCrudifyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CrudifyCompilerPass());
        parent::build($container);
    }
}
