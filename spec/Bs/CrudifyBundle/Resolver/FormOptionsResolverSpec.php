<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Definition\Form\FormDefinition;
use Bs\CrudifyBundle\Form\OptionsProvider\OptionsInterface;
use Bs\CrudifyBundle\Resolver\FormOptionsResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormOptionsResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\FormOptionsResolver');
    }

    function it_should_throw_an_error_on_a_nonexistant_service(
        ContainerInterface $container,
        FormDefinition $definition,
        CrudControllerInterface $controller,
        DefinitionInterface $mappingDefinition
    ) {
        $service = 'this_service_does_not_exist';
        $container->has($service)->willReturn(false);

        $definition->getOptionsProvider()->willReturn($service);
        $definition->getParent()->willReturn($mappingDefinition);
        $mappingDefinition->getName()->willReturn('test');


        $this->setContainer($container);
        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\OptionsProviderNotFoundException')
            ->duringResolve($definition, FormOptionsResolver::TYPE_CREATE, $controller)
        ;
    }

    function it_should_throw_an_error_on_a_nonexistant_class(
        ContainerInterface $container,
        FormDefinition $definition,
        CrudControllerInterface $controller,
        DefinitionInterface $mappingDefinition
    ) {
        $class = 'Acme\\InvalidClasses\\NonExistantClass';
        $container->has($class)->willReturn(false);

        $definition->getOptionsProvider()->willReturn($class);
        $definition->getParent()->willReturn($mappingDefinition);
        $mappingDefinition->getName()->willReturn('test');

        $this->setContainer($container);
        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\OptionsProviderNotFoundException')
            ->duringResolve($definition, FormOptionsResolver::TYPE_CREATE, $controller)
        ;
    }

    function it_should_retrieve_create_options_for_a_service(
        ContainerInterface $container,
        FormDefinition $definition,
        CrudControllerInterface $controller,
        OptionsInterface $options,
        DefinitionInterface $mappingDefinition
    ) {
        $service = 'this_is_a_service';
        $generatedOptions = ['test' => 'value'];

        $container->has($service)->willReturn(true);
        $container->get($service)->willReturn($options);

        $definition->getOptionsProvider()->willReturn($service);
        $definition->getParent()->willReturn($mappingDefinition);

        $mappingDefinition->getName()->shouldNotBeCalled();

        $options->getCreateOptions($controller, $mappingDefinition)->shouldBeCalled()->willReturn($generatedOptions);

        $this->setContainer($container);
        $this->resolve($definition, FormOptionsResolver::TYPE_CREATE, $controller)->shouldReturn($generatedOptions);
    }

    function it_should_retrieve_create_options_for_a_class(
        ContainerInterface $container,
        FormDefinition $definition,
        CrudControllerInterface $controller,
        OptionsInterface $options,
        DefinitionInterface $mappingDefinition
    ) {
        $class = 'Bs\\CrudifyBundle\\Tests\\Fixtures\\Form\\OptionsProvider\\MockOptionsProvider';




    }

    function it_should_retrieve_update_options_for_a_service()
    {

    }

    function it_should_retrieve_update_options_for_a_class()
    {

    }

    function it_should_throw_an_error_if_it_does_not_understand_the_type()
    {

    }
}
