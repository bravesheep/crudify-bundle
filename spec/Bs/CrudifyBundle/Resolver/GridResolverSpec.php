<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Knp\Component\Pager\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GridResolverSpec extends ObjectBehavior
{
    function let(Paginator $paginator)
    {
        $this->beConstructedWith($paginator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\GridResolver');
    }
}
