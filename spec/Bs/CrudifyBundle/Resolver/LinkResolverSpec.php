<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Resolver\IdentityResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\RouterInterface;

class LinkResolverSpec extends ObjectBehavior
{
    function let(RouterInterface $router, IdentityResolver $identityResolver)
    {
        $this->beConstructedWith($router, $identityResolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\LinkResolver');
    }
}
