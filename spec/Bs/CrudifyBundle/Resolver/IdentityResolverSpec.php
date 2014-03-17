<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdentityResolverSpec extends ObjectBehavior
{
    function let(DefinitionInterface $definition, EntityManager $manager)
    {
        $definition->getEntityManager()->willReturn($manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\IdentityResolver');
    }
}
