<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Resolver\IdentityResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Routing\RouterInterface;

class LinkResolverSpec extends ObjectBehavior
{
    function let(
        RouterInterface $router,
        IdentityResolver $identityResolver,
        DefinitionInterface $definition,
        \stdClass $object
    ) {
        $this->beConstructedWith($router, $identityResolver);

        $router->generate('bs_crudify.index', Argument::withKey('mapping'))->will(function ($args) {
            return  '/' . $args[1]['mapping'] . '/index';
        });
        $router->generate('bs_crudify.new', Argument::withKey('mapping'))->will(function ($args) {
            return '/' . $args[1]['mapping'] . '/new';
        });
        $router->generate('bs_crudify.create', Argument::withKey('mapping'))->will(function ($args) {
            return '/' . $args[1]['mapping'] . '/create';
        });
        $router
            ->generate('bs_crudify.edit', Argument::allOf(Argument::withKey('mapping'), Argument::withKey('id')))
            ->will(function ($args) {
                return '/' . $args[1]['mapping'] . '/edit/' . $args[1]['id'];
            })
        ;
        $router
            ->generate('bs_crudify.update', Argument::allOf(Argument::withKey('mapping'), Argument::withKey('id')))
            ->will(function ($args) {
                return '/' . $args[1]['mapping'] . '/update/' . $args[1]['id'];
            })
        ;
        $router
            ->generate('bs_crudify.delete', Argument::allOf(Argument::withKey('mapping'), Argument::withKey('id')))
            ->will(function ($args) {
                return '/' . $args[1]['mapping'] . '/delete/' . $args[1]['id'];
            })
        ;

        $definition->getName()->willReturn('test');

        $identityResolver->getId($definition, $object)->willReturn(42);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\LinkResolver');
    }

    function it_should_retrieve_the_index_link(DefinitionInterface $definition)
    {
        $this->getLinkForAction('index', $definition)->shouldReturn('/test/index');
    }

    function it_should_retrieve_the_new_link(DefinitionInterface $definition)
    {
        $this->getLinkForAction('new', $definition)->shouldReturn('/test/new');
    }

    function it_should_retrieve_the_create_link(DefinitionInterface $definition)
    {
        $this->getLinkForAction('create', $definition)->shouldReturn('/test/create');
    }

    function it_should_retrieve_the_edit_link_for_an_object(DefinitionInterface $definition, \stdClass $object)
    {
        $this->getLinkForAction('edit', $definition, $object)->shouldReturn('/test/edit/42');
    }

    function it_should_retrieve_the_edit_link_for_an_id(DefinitionInterface $definition)
    {
        $this->getLinkForAction('edit', $definition, 37)->shouldReturn('/test/edit/37');
    }

    function it_should_retrieve_the_update_link_for_an_object(DefinitionInterface $definition, \stdClass $object)
    {
        $this->getLinkForAction('update', $definition, $object)->shouldReturn('/test/update/42');
    }

    function it_should_retrieve_the_update_link_for_an_id(DefinitionInterface $definition)
    {
        $this->getLinkForAction('update', $definition, 37)->shouldReturn('/test/update/37');
    }

    function it_should_retrieve_the_delete_link_for_an_object(DefinitionInterface $definition, \stdClass $object)
    {
        $this->getLinkForAction('delete', $definition, $object)->shouldReturn('/test/delete/42');
    }

    function it_should_retrieve_the_delete_link_for_an_id(DefinitionInterface $definition)
    {
        $this->getLinkForAction('delete', $definition, 37)->shouldReturn('/test/delete/37');
    }
}
