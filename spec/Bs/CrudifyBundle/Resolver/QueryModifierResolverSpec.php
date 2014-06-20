<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Query\ModifierInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class QueryModifierResolverSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Resolver\QueryModifierResolver');
    }

    function it_should_resolve_a_service(ContainerInterface $container, ModifierInterface $modifier)
    {
        $service = 'this_is_a_service';
        $container->has($service)->willReturn(true);
        $container->get($service)->willReturn($modifier);

        $this->resolve($service)->shouldReturn($modifier);
    }

    function it_should_throw_an_error_for_a_nonexistant_service(ContainerInterface $container)
    {
        $service = 'this_service_does_not_exist';
        $container->has($service)->willReturn(false);

        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\QueryModifierNotFoundException')
            ->duringResolve($service)
        ;
    }

    function it_should_resolve_a_class(ContainerInterface $container)
    {
        $class = 'Bravesheep\\CrudifyBundle\\Tests\\Fixtures\\Query\\MockModifier';
        $container->has($class)->willReturn(false);

        $this->resolve($class)->shouldBeAnInstanceOf($class);
    }

    function it_should_throw_an_error_for_a_nonexistant_class(ContainerInterface $container)
    {
        $class = 'Acme\\Nonexistant\\Modifier';
        $container->has($class)->willReturn(false);

        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\QueryModifierNotFoundException')
            ->duringResolve($class)
        ;
    }

    function it_should_return_a_passed_modifier_directly(ModifierInterface $modifier)
    {
        $this->resolve($modifier)->shouldReturn($modifier);
    }

    function it_should_throw_an_error_for_incompatible_types()
    {
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\QueryModifierNotFoundException')
            ->duringResolve(10)
        ;
    }
}
