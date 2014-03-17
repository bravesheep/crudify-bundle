<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormTypeInterface;

class FormResolverSpec extends ObjectBehavior
{
    function let(
        ContainerInterface $container
    ) {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\FormResolver');
    }

    function it_should_resolve_a_form_service(
        ContainerInterface $container,
        FormTypeInterface $form
    ) {
        $service = 'this_is_a_service';

        $container->has($service)->willReturn(true);
        $container->get($service)->willReturn($form);

        $this->resolve($service)->shouldReturn($form);
    }

    function it_should_resolve_a_form_class(
        ContainerInterface $container
    ) {
        $class = 'Bs\\CrudifyBundle\\Tests\\Fixtures\\Form\\ExampleFormType';

        $container->has($class)->willReturn(false);

        $this->resolve($class)->shouldBeAnInstanceOf($class);
    }

    function it_should_set_the_container_of_a_container_aware_class(
        ContainerInterface $container
    ) {
        $class = 'Bs\\CrudifyBundle\\Tests\\Fixtures\\Form\\ExampleContainerAwareFormType';

        $container->has($class)->willReturn(false);

        $resolved = $this->resolve($class);
        $resolved->shouldBeAnInstanceOf($class);
        $resolved->container->shouldBe($container);
    }

    function it_should_throw_an_error_for_a_nonexistant_service(
        ContainerInterface $container
    ) {
        $service = 'this_service_does_not_exist';
        $container->has($service)->willReturn(false);

        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\FormNotFoundException')
            ->duringResolve($service)
        ;
    }

    function it_should_throw_an_error_for_a_nonexistant_class(
        ContainerInterface $container
    ) {
        $class = 'Simple\\Nonexistant\\FormType';
        $container->has($class)->willReturn(false);

        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\FormNotFoundException')
            ->duringResolve($class)
        ;
    }

    function it_should_throw_an_error_for_invalid_types()
    {
        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\FormNotFoundException')
            ->duringResolve(10)
        ;
    }

    function it_should_return_a_provided_form_argument(
        FormTypeInterface $form
    ) {
        $this->resolve($form)->shouldReturn($form);
    }
}
