<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ControllerResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\ControllerResolver');
    }

    function it_should_throw_an_error_on_a_nonexistant_service()
    {

    }

    function it_should_throw_an_error_on_a_nonexistant_class()
    {

    }

    function it_should_retrieve_an_existing_service()
    {

    }

    function it_should_retrieve_an_existing_class()
    {

    }

    function it_should_not_create_the_same_class_twice()
    {

    }

    function it_should_throw_an_error_if_it_does_not_understand_the_type()
    {

    }

    function it_should_return_the_controller_if_the_argument_is_already_a_controller()
    {

    }
}
