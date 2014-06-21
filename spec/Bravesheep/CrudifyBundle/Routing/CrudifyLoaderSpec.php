<?php

namespace spec\Bravesheep\CrudifyBundle\Routing;

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
        $collection->get('bravesheep_crudify.index')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bravesheep_crudify.new')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bravesheep_crudify.create')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bravesheep_crudify.edit')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bravesheep_crudify.update')->shouldBeAnInstanceOf($routeClass);
        $collection->get('bravesheep_crudify.delete')->shouldBeAnInstanceOf($routeClass);

        $collection->get('bravesheep_crudify.index')->getMethods()->shouldReturn(['GET']);
        $collection->get('bravesheep_crudify.new')->getMethods()->shouldReturn(['GET']);
        $collection->get('bravesheep_crudify.create')->getMethods()->shouldReturn(['POST']);
        $collection->get('bravesheep_crudify.edit')->getMethods()->shouldReturn(['GET']);
        $collection->get('bravesheep_crudify.update')->getMethods()->shouldReturnArrayValues(['PUT', 'PATCH']);
        $collection->get('bravesheep_crudify.delete')->getMethods()->shouldReturn(['DELETE']);
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
