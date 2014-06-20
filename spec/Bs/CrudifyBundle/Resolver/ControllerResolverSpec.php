<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Controller\CrudControllerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Resolver\ControllerResolver');
    }

    function it_should_throw_an_error_on_a_nonexistant_service(ContainerInterface $container)
    {
        $service = 'this_is_not_a_service';
        $container->has($service)->willReturn(false);
        $this->setContainer($container);
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\ControllerNotFoundException')
            ->duringResolve($service)
        ;
    }

    function it_should_throw_an_error_on_a_nonexistant_class(ContainerInterface $container)
    {
        $class = 'This\\Is\\Not\\A\\Class';
        $container->has($class)->willReturn(false);
        $this->setContainer($container);
        $this
            ->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\ControllerNotFoundException')
            ->duringResolve($class)
        ;
    }

    function it_should_retrieve_an_existing_service(ContainerInterface $container, CrudControllerInterface $controller)
    {
        $serviceName = 'this_is_a_service';
        $container->has($serviceName)->willReturn(true);
        $container->get($serviceName)->willReturn($controller);

        $this->setContainer($container);
        $this->resolve($serviceName)->shouldReturn($controller);
    }

    function it_should_retrieve_an_existing_class(ContainerInterface $container)
    {
        $class = 'Bravesheep\\CrudifyBundle\\Tests\\Fixtures\\Controller\\ExtendedController';
        $container->has($class)->willReturn(false);

        $this->setContainer($container);
        $this->resolve($class)->shouldBeAnInstanceOf($class);
    }

    function it_should_not_create_the_same_class_twice(ContainerInterface $container)
    {
        $class = 'Bravesheep\\CrudifyBundle\\Tests\\Fixtures\\Controller\\ExtendedController';
        $container->has($class)->willReturn(false);

        $this->setContainer($container);
        $this->resolve($class)->shouldReturn($this->resolve($class));
    }

    function it_should_throw_an_error_if_it_does_not_understand_the_type()
    {
        $this->shouldThrow('Bravesheep\\CrudifyBundle\\Exception\\ControllerNotFoundException')->duringResolve(10);
    }

    function it_should_return_the_controller_if_the_argument_is_already_a_controller(CrudControllerInterface $controller)
    {
        $this->resolve($controller)->shouldReturn($controller);
    }
}
