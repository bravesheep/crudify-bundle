<?php

namespace spec\Bs\CrudifyBundle\Event;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CrudifyEventSpec extends ObjectBehavior
{
    function let(\stdClass $object, DefinitionInterface $definition)
    {
        $this->beConstructedWith($object, $definition);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Event\CrudifyEvent');
    }

    function it_should_initialize_all_properties(\stdClass $object, DefinitionInterface $definition)
    {
        $this->getObject()->shouldReturn($object);
        $this->getDefinition()->shouldReturn($definition);
    }
}
