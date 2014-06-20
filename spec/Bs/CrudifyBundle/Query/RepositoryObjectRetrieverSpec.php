<?php

namespace spec\Bs\CrudifyBundle\Query;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryObjectRetrieverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Query\RepositoryObjectRetriever');
    }

    function it_should_retrieve_the_object_from_the_repository(
        DefinitionInterface $definition,
        EntityRepository $repo,
        \stdClass $object
    ) {
        $definition->getEntityRepository()->willReturn($repo);
        $repo->find(10)->shouldBeCalled()->willReturn($object);
        $this->retrieve($definition, 10)->shouldReturn($object);
    }
}
