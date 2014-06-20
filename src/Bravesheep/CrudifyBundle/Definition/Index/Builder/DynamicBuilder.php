<?php

namespace Bravesheep\CrudifyBundle\Definition\Index\Builder;

use Doctrine\Bundle\DoctrineBundle\Registry;

class DynamicBuilder extends AbstractBuilder
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function build(array $options)
    {
        throw new \BadMethodCallException("Build method not yet implemented");
    }
}
