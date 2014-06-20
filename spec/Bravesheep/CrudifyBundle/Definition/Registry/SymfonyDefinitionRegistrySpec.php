<?php

namespace spec\Bravesheep\CrudifyBundle\Definition\Registry;

use Bravesheep\CrudifyBundle\Definition\Loader\DIDefinitionLoader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SymfonyDefinitionRegistrySpec extends ObjectBehavior
{
    function let(DIDefinitionLoader $loader)
    {
        $this->beConstructedWith($loader);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Registry\SymfonyDefinitionRegistry');
    }

    function it_should_call_the_loader_when_adding_mappings(DIDefinitionLoader $loader)
    {
        $mappings = [
            'some' => 'mappings'
        ];
        $loader->loadAll($mappings, $this)->shouldBeCalled();
        $this->addMappings($mappings);
    }
}
