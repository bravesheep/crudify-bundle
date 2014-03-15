<?php

namespace spec\Bs\CrudifyBundle\Form\OptionsProvider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BasicOptionsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Form\OptionsProvider\BasicOptions');
    }
}
