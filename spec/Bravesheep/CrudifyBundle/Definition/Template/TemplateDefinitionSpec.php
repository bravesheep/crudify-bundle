<?php

namespace spec\Bravesheep\CrudifyBundle\Definition\Template;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateDefinitionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Template\TemplateDefinition');
    }

    function its_index_should_be_null_by_default()
    {
        $this->getIndex()->shouldReturn(null);
    }

    function its_new_should_be_null_by_default()
    {
        $this->getNew()->shouldReturn(null);
    }

    function its_edit_should_be_null_by_default()
    {
        $this->getEdit()->shouldReturn(null);
    }

    function its_formTheme_should_be_null_by_default()
    {
        $this->getFormTheme()->shouldReturn(null);
    }

    function its_pagination_should_be_null_by_default()
    {
        $this->getPagination()->shouldReturn(null);
    }

    function its_sortable_should_be_null_by_default()
    {
        $this->getSortable()->shouldReturn(null);
    }

    function its_layout_should_be_null_by_default()
    {
        $this->getLayout()->shouldReturn(null);
    }

    function its_parent_should_be_null_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    function its_index_should_be_modifyable()
    {
        $this->setIndex('index.html.twig');
        $this->getIndex()->shouldReturn('index.html.twig');
    }

    function its_new_should_be_modifyable()
    {
        $this->setNew('new.html.twig');
        $this->getNew()->shouldReturn('new.html.twig');
    }

    function its_edit_should_be_modifyable()
    {
        $this->setEdit('edit.html.twig');
        $this->getEdit()->shouldReturn('edit.html.twig');
    }

    function its_formTheme_should_be_modifyable()
    {
        $this->setFormTheme('formTheme.html.twig');
        $this->getFormTheme()->shouldReturn('formTheme.html.twig');
    }

    function its_pagination_should_be_modifyable()
    {
        $this->setPagination('pagination.html.twig');
        $this->getPagination()->shouldReturn('pagination.html.twig');
    }

    function its_sortable_should_be_modifyable()
    {
        $this->setSortable('sortable.html.twig');
        $this->getSortable()->shouldReturn('sortable.html.twig');
    }

    function its_layout_should_be_modifyable()
    {
        $this->setLayout('layout.html.twig');
        $this->getLayout()->shouldReturn('layout.html.twig');
    }

    function its_parent_should_be_modifyable(DefinitionInterface $definition)
    {
        $this->setParent($definition);
        $this->getParent()->shouldReturn($definition);
    }
}
