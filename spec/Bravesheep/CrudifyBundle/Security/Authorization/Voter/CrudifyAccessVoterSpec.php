<?php

namespace spec\Bravesheep\CrudifyBundle\Security\Authorization\Voter;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class CrudifyAccessVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Security\Authorization\Voter\CrudifyAccessVoter');
    }

    function it_should_support_all_crudify_attributes()
    {
        $this->supportsAttribute('CRUDIFY_INDEX')->shouldReturn(true);
        $this->supportsAttribute('CRUDIFY_CREATE')->shouldReturn(true);
        $this->supportsAttribute('CRUDIFY_UPDATE')->shouldReturn(true);
        $this->supportsAttribute('CRUDIFY_DELETE')->shouldReturn(true);
    }

    function it_should_not_support_other_attributes()
    {
        $this->supportsAttribute('SOME_OTHER_ATTRIBUTE')->shouldReturn(false);
    }

    function it_should_support_definition_objects(DefinitionInterface $definition)
    {
        $this->supportsClass($definition)->shouldReturn(true);
    }

    function it_should_not_support_non_definition_objects(\stdClass $object)
    {
        $this->supportsClass($object)->shouldReturn(false);
        $this->supportsClass(10)->shouldReturn(false);
    }

    function it_should_abstain_on_non_supported_attributes_or_objects(
        TokenInterface $token,
        \stdClass $object,
        DefinitionInterface $definition
    ) {
        $this->vote($token, $object, ['CRUDIFY_CREATE'])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
        $this->vote($token, $object, ['SOME_OTHER_ATTRIBUTE'])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
        $this->vote($token, $definition, ['SOME_OTHER_ATTRIBUTE'])->shouldReturn(VoterInterface::ACCESS_ABSTAIN);
    }

    function it_should_grant_if_that_is_the_default_for_the_index(
        DefinitionInterface $definition,
        TokenInterface $token
    ) {
        $this->beConstructedWith('grant');
        $this->vote($token, $definition, ['CRUDIFY_INDEX'])->shouldReturn(VoterInterface::ACCESS_GRANTED);
    }

    function it_should_deny_if_that_is_the_default_for_the_index(
        TokenInterface $token,
        DefinitionInterface $definition
    ) {
        $this->beConstructedWith('deny');
        $this->vote($token, $definition, ['CRUDIFY_INDEX'])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_should_not_be_constructed_with_an_invalid_default()
    {
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\CrudifyException')
            ->during('__construct', ['test'])
        ;
    }

    function it_should_not_allow_create_access_if_the_definition_denies(
        DefinitionInterface $definition,
        TokenInterface $token
    ) {
        $definition->withCreate()->willReturn(false);
        $this->vote($token, $definition, ['CRUDIFY_CREATE'])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_should_not_allow_update_access_if_the_definition_denies(
        DefinitionInterface $definition,
        TokenInterface $token
    ) {
        $definition->withUpdate()->willReturn(false);
        $this->vote($token, $definition, ['CRUDIFY_UPDATE'])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }

    function it_should_not_allow_delete_access_if_the_definition_denies(
        DefinitionInterface $definition,
        TokenInterface $token
    ) {
        $definition->withDelete()->willReturn(false);
        $this->vote($token, $definition, ['CRUDIFY_DELETE'])->shouldReturn(VoterInterface::ACCESS_DENIED);
    }
}
