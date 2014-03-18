<?php

namespace spec\Bs\CrudifyBundle\Definition\Registry;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefinitionRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Definition\Registry\DefinitionRegistry');
    }

    function it_should_have_no_definitions_by_default()
    {
        $this->getDefinitions()->shouldHaveCount(0);
    }

    function it_should_be_able_to_add_a_definition(DefinitionInterface $definition)
    {
        $name = 'some_definition';
        $this->addDefinition($definition, $name);
        $this->hasDefinition($name)->shouldReturn(true);
        $this->getDefinition($name)->shouldReturn($definition);
        $this->getDefinedNames()->shouldHaveCount(1);
        $this->getDefinedNames()->shouldContain($name);
        $this->getDefinitions()->shouldHaveCount(1);
        $this->getDefinitions()->shouldContain($definition);
    }
}
