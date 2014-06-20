<?php

namespace spec\Bravesheep\CrudifyBundle\Definition\Index;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IndexDefinitionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Index\IndexDefinition');
    }

    function it_should_have_no_colums_by_default()
    {
        return $this->getColumns()->shouldHaveCount(0);
    }

    function it_should_have_ascending_sort_order_by_default()
    {
        return $this->getDefaultSortDirection()->shouldReturn('asc');
    }

    function it_should_add_a_column_to_the_list_of_columns(ColumnInterface $column)
    {
        $column->getName()->willReturn('column');
        $column->setParent($this)->willReturn();

        $this->addColumn($column);
        $this->getColumns()->shouldHaveCount(1);
        $this->getColumns()->shouldContain($column);
        $this->hasColumn('column')->shouldReturn(true);
    }

    function it_should_add_multiple_columns_at_the_end_of_the_list(
        ColumnInterface $first,
        ColumnInterface $second,
        ColumnInterface $third
    ) {
        $first->getName()->willReturn('first');
        $first->setParent($this)->willReturn();
        $second->getName()->willReturn('second');
        $second->setParent($this)->willReturn();
        $third->getName()->willReturn('third');
        $third->setParent($this)->willReturn();

        $this->addColumn($first);
        $this->addColumn($second);
        $this->addColumn($third);
        $this->getColumns()->shouldHaveCount(3);
        $this->getColumns()->shouldReturn([
            $first,
            $second,
            $third
        ]);
        $this->hasColumn('first')->shouldReturn(true);
        $this->hasColumn('second')->shouldReturn(true);
        $this->hasColumn('third')->shouldReturn(true);
    }

    function it_should_have_no_sorting_column_by_default()
    {
        $this->getDefaultSortColumn()->shouldReturn(null);
    }

    function its_defaultSort_should_be_modifyable(ColumnInterface $column)
    {
        $this->setDefaultSort($column, 'desc');
        $this->getDefaultSortColumn()->shouldReturn($column);
        $this->getDefaultSortDirection()->shouldReturn('desc');
    }

    function it_should_set_the_parent_of_an_added_column(ColumnInterface $column)
    {
        $column->setParent($this)->shouldBeCalled();
        $this->addColumn($column);
    }

    function it_should_have_no_baseEntity_by_default()
    {
        $this->getBaseEntity()->shouldReturn(null);
    }

    function its_baseEntity_should_be_modifyable()
    {
        $entity = 'AcmeBundle:Test';
        $this->setBaseEntity($entity);
        $this->getBaseEntity()->shouldReturn($entity);
    }

    function it_should_have_no_parent_by_default()
    {
        $this->getParent()->shouldReturn(null);
    }

    function its_parent_should_be_modifyable(DefinitionInterface $definition)
    {
        $this->setParent($definition);
        $this->getParent()->shouldReturn($definition);
    }

    function its_objectsPerPage_should_be_an_integer_by_default()
    {
        $this->getObjectsPerPage()->shouldBeInteger();
    }

    function its_objectsPerPage_should_be_modifyable()
    {
        $this->setObjectsPerPage(109);
        $this->getObjectsPerPage()->shouldReturn(109);
    }

    function it_should_have_no_query_modifier_by_default()
    {
        $this->hasQueryModifier()->shouldReturn(false);
        $this->getQueryModifier()->shouldReturn(null);
    }

    function its_queryModifier_should_be_modifyable()
    {
        $modifier = 'some_modifier_service';
        $this->setQueryModifier($modifier);
        $this->hasQueryModifier()->shouldReturn(true);
        $this->getQueryModifier()->shouldReturn($modifier);
    }

    function it_should_indicate_a_column_with_some_field_should_exist(
        ColumnInterface $first,
        ColumnInterface $second
    ) {
        $first->getField()->willReturn('some_field');
        $second->getField()->willReturn('another_field');
        $first->setParent($this)->willReturn();
        $second->setParent($this)->willReturn();

        $this->addColumn($first);
        $this->addColumn($second);

        $this->hasColumnWithField('another_field')->shouldReturn(true);
        $this->hasColumnWithField('nonexistant_field')->shouldReturn(false);
    }

    function it_should_iterate_over_the_columns(
        ColumnInterface $first,
        ColumnInterface $second
    ) {
        $this->addColumn($first);
        $this->addColumn($second);

        $iterator = $this->getIterator();
        $iterator->shouldBeAnInstanceOf('Iterator');
        $iterator->current()->shouldReturn($first);
        $iterator->next();
        $iterator->current()->shouldReturn($second);
        $iterator->next();
        $iterator->valid()->shouldReturn(false);
    }
}
