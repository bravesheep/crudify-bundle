<?php

namespace spec\Bs\CrudifyBundle\Definition\Index\Column;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ColumnSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Definition\Index\Column\Column');
    }
}
