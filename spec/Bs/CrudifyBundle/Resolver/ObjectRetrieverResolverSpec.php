<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ObjectRetrieverResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\ObjectRetrieverResolver');
    }
}
