<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Query\ObjectRetrieverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ObjectRetrieverResolverSpec extends ObjectBehavior
{
    function let(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\ObjectRetrieverResolver');
    }

    function it_should_resolve_a_service(ContainerInterface $container, ObjectRetrieverInterface $retriever)
    {
        $service = 'this_is_a_service';
        $container->has($service)->willReturn(true);
        $container->get($service)->willReturn($retriever);

        $this->resolve($service)->shouldReturn($retriever);
    }

    function it_should_resolve_a_class(ContainerInterface $container)
    {
        $class = 'Bs\\CrudifyBundle\\Tests\\Fixtures\\Query\\MockObjectRetriever';
        $container->has($class)->willReturn(false);
        $this->resolve($class)->shouldReturnAnInstanceOf($class);
    }

    function it_should_return_a_passed_object_retriever(ObjectRetrieverInterface $retriever)
    {
        $this->resolve($retriever)->shouldReturn($retriever);
    }

    function it_should_throw_an_exception_for_a_nonexistant_service(ContainerInterface $container)
    {
        $service = 'this_service_does_not_exist';
        $container->has($service)->willReturn(false);

        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\ObjectRetrieverNotFoundException')
            ->duringResolve($service)
        ;
    }

    function it_should_throw_an_exception_for_a_nonexistant_class(ContainerInterface $container)
    {
        $class = 'Acme\\Nonexistant\\ObjectRetriever';
        $container->has($class)->willReturn(false);

        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\ObjectRetrieverNotFoundException')
            ->duringResolve($class)
        ;
    }

    function it_should_throw_an_exception_for_an_invalid_type()
    {
        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\ObjectRetrieverNotFoundException')
            ->duringResolve(10)
        ;
    }
}
