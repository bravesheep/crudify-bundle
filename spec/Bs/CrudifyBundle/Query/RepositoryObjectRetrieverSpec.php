<?php

namespace spec\Bs\CrudifyBundle\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryObjectRetrieverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Query\RepositoryObjectRetriever');
    }
}
