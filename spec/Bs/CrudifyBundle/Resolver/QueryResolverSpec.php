<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Resolver\IdentityResolver;
use Bs\CrudifyBundle\Resolver\QueryModifierResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueryResolverSpec extends ObjectBehavior
{
    function let(IdentityResolver $identityResolver, QueryModifierResolver $queryModifierResolver)
    {
        $this->beConstructedWith($identityResolver, $queryModifierResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\QueryResolver');
    }
}
