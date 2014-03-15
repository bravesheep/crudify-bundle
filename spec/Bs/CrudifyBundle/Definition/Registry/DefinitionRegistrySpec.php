<?php

namespace spec\Bs\CrudifyBundle\Definition\Registry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefinitionRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Definition\Registry\DefinitionRegistry');
    }
}
