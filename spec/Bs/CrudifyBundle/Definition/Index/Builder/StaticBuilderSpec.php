<?php

namespace spec\Bs\CrudifyBundle\Definition\Index\Builder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StaticBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Index\Builder\StaticBuilder');
    }

    function it_should_build_the_correct_definition_if_all_settings_are_defined()
    {
        $options = [
            'entity' => 'AcmeBundle:Example',
            'index' => [
                'query_modifier' => 'query_modifier',
                'page_limit' => 293,
                'sort' => [
                    'column' => 'sort_column',
                    'direction' => 'desc',
                ],
                'columns' => [
                    'first' => [
                        'title' => 'First',
                        'path' => 'path.to.first',
                        'type' => 'text',
                    ],
                    'second' => [
                        'title' => 'Second',
                        'path' => 'path.to.second',
                        'type' => 'second_type',
                    ],
                ],
            ],
        ];

        $definition = $this->build($options);
        $definition->getColumns()->shouldHaveCount(2);
        $definition->getBaseEntity()->shouldReturn('AcmeBundle:Example');
        $definition->getQueryModifier()->shouldReturn('query_modifier');
        $definition->getObjectsPerPage()->shouldReturn(293);

        $columnType = 'Bravesheep\\CrudifyBundle\\Definition\\Index\\Column\\ColumnInterface';

        $definition->getDefaultSortColumn()->shouldReturnAnInstanceOf($columnType);
        $definition->getDefaultSortColumn()->getName()->shouldReturn('sort_column');
        $definition->getDefaultSortColumn()->getPath()->shouldReturn('sort_column');
        $definition->getDefaultSortDirection()->shouldReturn('desc');

        $definition->getColumn('first')->shouldReturnAnInstanceOf($columnType);
        $definition->getColumn('second')->shouldReturnAnInstanceOf($columnType);

        $definition->getColumn('first')->getName()->shouldReturn('first');
        $definition->getColumn('first')->getTitle()->shouldReturn('First');
        $definition->getColumn('first')->getPath()->shouldReturn('path.to.first');
        $definition->getColumn('first')->getType()->shouldReturn('text');

        $definition->getColumn('second')->getName()->shouldReturn('second');
        $definition->getColumn('second')->getTitle()->shouldReturn('Second');
        $definition->getColumn('second')->getPath()->shouldReturn('path.to.second');
        $definition->getColumn('second')->getType()->shouldReturn('second_type');
    }

    function it_should_infer_the_correct_definition_if_column_title_and_path_are_not_defined()
    {
        $options = [
            'entity' => 'AcmeBundle:Example',
            'index' => [
                'query_modifier' => 'query_modifier',
                'page_limit' => 293,
                'sort' => [
                    'column' => 'sort_column',
                    'direction' => 'asc',
                ],
                'columns' => [
                    'first.path' => [
                        'title' => null,
                        'path' => null,
                        'type' => 'text',
                    ],
                    'second' => [
                        'title' => null,
                        'path' => null,
                        'type' => 'second_type',
                    ],
                ],
            ],
        ];

        $definition = $this->build($options);

        $columnType = 'Bravesheep\\CrudifyBundle\\Definition\\Index\\Column\\ColumnInterface';

        $definition->getColumn('first.path')->shouldReturnAnInstanceOf($columnType);
        $definition->getColumn('second')->shouldReturnAnInstanceOf($columnType);

        $definition->getColumn('first.path')->getName()->shouldReturn('first.path');
        $definition->getColumn('first.path')->getTitle()->shouldReturn('First path');
        $definition->getColumn('first.path')->getPath()->shouldReturn('first.path');
        $definition->getColumn('first.path')->getType()->shouldReturn('text');

        $definition->getColumn('second')->getName()->shouldReturn('second');
        $definition->getColumn('second')->getTitle()->shouldReturn('Second');
        $definition->getColumn('second')->getPath()->shouldReturn('second');
        $definition->getColumn('second')->getType()->shouldReturn('second_type');
    }

    function it_should_reuse_existing_columns_if_the_sort_column_already_exists()
    {
        $options = [
            'entity' => 'AcmeBundle:Example',
            'index' => [
                'query_modifier' => 'query_modifier',
                'page_limit' => 293,
                'sort' => [
                    'column' => 'first',
                    'direction' => 'asc',
                ],
                'columns' => [
                    'first' => [
                        'title' => 'First',
                        'path' => 'path.to.first',
                        'type' => 'text',
                    ],
                    'second' => [
                        'title' => 'Second',
                        'path' => 'path.to.second',
                        'type' => 'second_type',
                    ],
                ],
            ],
        ];
        $definition = $this->build($options);
        $definition->getColumn('first')->shouldReturn($definition->getDefaultSortColumn());
    }
}
