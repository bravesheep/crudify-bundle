<?php

namespace spec\Bs\CrudifyBundle\Definition\Form;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormDefinitionSpec extends ObjectBehavior
{
    private $create = 'create';

    private $update = 'update';

    function let()
    {
        $this->beConstructedWith($this->create, $this->update);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Definition\Form\FormDefinition');
    }

    function it_should_return_the_constructor_arguments()
    {
        $this->getCreateForm()->shouldReturn($this->create);
        $this->getUpdateForm()->shouldReturn($this->update);
    }

    function its_parent_should_be_modifyable(DefinitionInterface $definition)
    {
        $this->setParent($definition);
        $this->getParent()->shouldReturn($definition);
    }

    function its_optionsProvider_should_be_modifyable()
    {
        $provider = 'some_options_provider';
        $this->setOptionsProvider($provider);
        $this->getOptionsProvider()->shouldReturn($provider);
    }

    function it_should_have_a_default_null_optionsProvider()
    {
        $this->getOptionsProvider()->shouldReturn(null);
    }

    function it_should_have_a_default_null_parent()
    {
        $this->getParent()->shouldReturn(null);
    }
}
