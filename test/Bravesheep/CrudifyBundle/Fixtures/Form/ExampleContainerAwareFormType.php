<?php

namespace Bravesheep\CrudifyBundle\Fixtures\Form;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;

class ExampleContainerAwareFormType extends AbstractType implements ContainerAwareInterface
{
    public $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'test_example_container_aware';
    }
}
