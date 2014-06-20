<?php

namespace spec\Bravesheep\CrudifyBundle\Definition\Index\Builder\Registry;

use Bravesheep\CrudifyBundle\Definition\Index\Builder\BuilderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Index\Builder\Registry\BuilderRegistry');
    }

    function it_should_have_no_builders_by_default()
    {
        return $this->getDefinedBuilders()->shouldHaveCount(0);
    }

    function it_should_allow_adding_a_builder(BuilderInterface $builder)
    {
        $this->addBuilder($builder, 'some_name');
        $this->hasBuilder('some_name')->shouldReturn(true);
        $this->getBuilder('some_name')->shouldReturn($builder);
        $this->getDefinedBuilders()->shouldHaveCount(1);
        $this->getDefinedBuilders()->shouldContain('some_name');
    }

    function it_should_throw_an_error_if_it_cannot_find_a_builder()
    {
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\BuilderNotFoundException')
            ->duringGetBuilder('nonexistant_builder')
        ;
    }
}
