<?php

namespace spec\Bs\CrudifyBundle\Form\OptionsProvider;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BasicOptionsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Form\OptionsProvider\BasicOptions');
    }

    function let(CrudControllerInterface $controller, DefinitionInterface $definition)
    {
        $controller->getLink('create', $definition)->willReturn('/create');
        $controller->getLink('update', $definition, Argument::any())->will(function ($args) {
            return '/update/' . $args[2];
        });
    }

    function its_getCreateOptions_should_retrieve_options(
        CrudControllerInterface $controller,
        DefinitionInterface $definition
    ) {
        $result = $this->getCreateOptions($controller, $definition);
        $result->shouldContainKeyValue('method', 'POST');
        $result->shouldContainKeyValue('action', '/create');
    }

    function its_getUpdateOptions_should_retrieve_options(
        CrudControllerInterface $controller,
        DefinitionInterface $definition
    ) {
        $result = $this->getUpdateOptions($controller, $definition, 10);
        $result->shouldContainKeyValue('method', 'PUT');
        $result->shouldContainKeyValue('action', '/update/10');
    }

    public function getMatchers()
    {
        return [
            'containKeyValue' => function ($subject, $key, $value) {
                return array_key_exists($key, $subject) && $subject[$key] === $value;
            }
        ];
    }
}
