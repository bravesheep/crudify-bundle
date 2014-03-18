<?php

namespace spec\Bs\CrudifyBundle\Definition\Index\Column;

use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ColumnSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Definition\Index\Column\Column');
    }

    function its_name_should_be_modifyable()
    {
        $this->setName('test');
        $this->getName()->shouldReturn('test');
    }

    function its_title_should_be_modifyable()
    {
        $this->setTitle('Test');
        $this->getTitle()->shouldReturn('Test');
    }

    function its_type_should_be_modifyable()
    {
        $this->setType('type');
        $this->getType()->shouldReturn('type');
    }

    function its_path_should_be_modifyable()
    {
        $this->setPath('some.path');
        $this->getPath()->shouldReturn('some.path');
    }

    function its_parent_should_be_modifyable(IndexDefinitionInterface $indexDefinition)
    {
        $this->setParent($indexDefinition);
        $this->getParent()->shouldReturn($indexDefinition);
    }

    function its_parent_should_be_null_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    function it_should_return_the_correct_field_name_for_a_complex_path()
    {
        $this->setPath('this.is.some.path');
        $this->getField()->shouldReturn('entity_this_is_some.path');
    }

    function it_should_return_the_correct_field_name_for_a_simple_path()
    {
        $this->setPath('base');
        $this->getField()->shouldReturn('entity.base');
    }

    function it_should_return_the_correct_table_for_a_field()
    {
        $this->setPath('some.path');
        $this->getTableName()->shouldReturn('entity_some');
    }

    function it_should_return_no_join_path_for_a_simple_field()
    {
        $this->setPath('simple');
        $this->getJoinPath()->shouldReturn([]);
    }

    function it_should_return_the_correct_join_path_for_a_field()
    {
        $this->setPath('some.example.field');
        $this->getJoinPath()->shouldReturn([
            [
                'table' => 'entity_some',
                'via' => 'entity.some',
            ],
            [
                'table' => 'entity_some_example',
                'via' => 'entity_some.example',
            ]
        ]);
    }

    function it_should_not_be_queryable_if_no_path_was_set()
    {
        $this->isQueryable()->shouldReturn(false);
    }

    function it_should_not_be_queryable_if_the_path_was_set_to_false()
    {
        $this->setPath(false);
        $this->isQueryable()->shouldReturn(false);
    }

    function it_should_be_queryable_if_the_path_was_set()
    {
        $this->setPath('some.path');
        $this->isQueryable()->shouldReturn(true);
    }
}
