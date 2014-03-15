<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Doctrine\Bundle\DoctrineBundle\Registry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdentityResolverSpec extends ObjectBehavior
{
    function let(Registry $doctrine)
    {
        $this->beConstructedWith($doctrine);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\IdentityResolver');
    }
}
