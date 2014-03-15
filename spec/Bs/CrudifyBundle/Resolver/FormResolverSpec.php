<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\FormResolver');
    }
}
