<?php

namespace spec\Bs\CrudifyBundle\Security\Authorization\Voter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CrudifyAccessVoterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Security\Authorization\Voter\CrudifyAccessVoter');
    }
}
