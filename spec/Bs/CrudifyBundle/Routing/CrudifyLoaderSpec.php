<?php

namespace spec\Bs\CrudifyBundle\Routing;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CrudifyLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Routing\CrudifyLoader');
    }

    function it_should_add_all_base_routes()
    {
        $routeClass = 'Symfony\\Component\\Routing\\Route';

        $collection = $this->load('.', 'crudify');
        $collection->get('bs_crudify.index')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bs_crudify.new')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bs_crudify.create')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bs_crudify.edit')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bs_crudify.update')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bs_crudify.delete')->shouldBeAnInstanceOf($routeClass);

        $collection->get('bs_crudify.index')->getMethods()->shouldReturn(['GET']);
        $collection->get('bs_crudify.new')->getMethods()->shouldReturn(['GET']);
        $collection->get('bs_crudify.create')->getMethods()->shouldReturn(['POST']);
        $collection->get('bs_crudify.edit')->getMethods()->shouldReturn(['GET']);
        $collection->get('bs_crudify.update')->getMethods()->shouldReturnArrayValues(['PUT', 'PATCH']);
        $collection->get('bs_crudify.delete')->getMethods()->shouldReturn(['DELETE']);
    }

    public function getMatchers()
    {
        return [
            'returnArrayValues' => function ($subject, $values) {
                foreach ($values as $value) {
                    if (!in_array($value, $subject, true)) {
                        return false;
                    }
                }
                return true;
            }
        ];
    }
}
