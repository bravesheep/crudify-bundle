<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdentityResolverSpec extends ObjectBehavior
{
    function let(DefinitionInterface $definition, EntityManager $manager, ClassMetadata $metadata)
    {
        $entity = 'AcmeBundle:Test';

        $definition->getName()->willReturn('test');
        $definition->getEntityName()->willReturn($entity);
        $definition->getEntityManager()->willReturn($manager);
        $manager->getClassMetadata($entity)->willReturn($metadata);
        $metadata->getName()->willReturn($entity);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Resolver\IdentityResolver');
    }

    function it_should_return_the_identity_column_if_there_is_exactly_one(
        DefinitionInterface $definition,
        ClassMetadata $metadata
    )
    {
        $metadata->getIdentifierFieldNames()->willReturn(['id']);
        $this->getIdentityColumn($definition)->shouldReturn('id');
    }

    function it_should_throw_an_exception_if_there_is_not_exactly_one_identity_column(
        DefinitionInterface $definition,
        ClassMetadata $metadata
    ) {
        $metadata->getIdentifierFieldNames()->willReturn(['some', 'id']);
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\UnsupportedEntityException')
            ->duringGetIdentityColumn($definition)
        ;
    }

    function it_should_return_the_identity_value_if_there_is_exactly_one(
        DefinitionInterface $definition,
        ClassMetadata $metadata,
        \stdClass $object
    ) {
        $metadata->getIdentifierValues($object)->willReturn([42]);
        $this->getId($definition, $object)->shouldReturn(42);
    }

    function it_should_throw_an_exception_if_there_is_not_exactly_one_identity_value(
        DefinitionInterface $definition,
        ClassMetadata $metadata,
        \stdClass $object
    ) {
        $metadata->getIdentifierValues($object)->willReturn([1, 2, 3]);
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\UnsupportedEntityException')
            ->duringGetId($definition, $object)
        ;
    }
}
