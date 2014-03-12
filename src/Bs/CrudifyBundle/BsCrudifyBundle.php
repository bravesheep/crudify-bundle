<?php

namespace Bs\CrudifyBundle;

use Bs\CrudifyBundle\DependencyInjection\CrudifyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BsCrudifyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CrudifyCompilerPass());
        parent::build($container);
    }
}
