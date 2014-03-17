<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Definition\Template\TemplateDefinitionInterface;
use Doctrine\ORM\AbstractQuery;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

class GridResolverSpec extends ObjectBehavior
{
    function let(
        Paginator $paginator,
        AbstractQuery $query,
        IndexDefinitionInterface $indexDefinition,
        SlidingPagination $pagination,
        DefinitionInterface $definition,
        TemplateDefinitionInterface $templateDefinition
    ) {
        $this->beConstructedWith($paginator);

        $indexDefinition->getObjectsPerPage()->willReturn(20);
        $paginator->paginate($query, Argument::type('int'), Argument::type('int'))->willReturn($pagination);

        $indexDefinition->getParent()->willReturn($definition);
        $definition->getTemplates()->willReturn($templateDefinition);

        $pagination->setParam(Argument::any(), Argument::any())->willReturn();
        $pagination->setTemplate(Argument::any())->will(function ($args) {
            $this->getTemplate()->willReturn($args[0]);
        });
        $pagination->setSortableTemplate(Argument::any())->will(function ($args) {
            $this->getSortableTemplate()->willReturn($args[0]);
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bs\CrudifyBundle\Resolver\GridResolver');
    }

    function it_should_retrieve_some_pagination(
        AbstractQuery $query,
        IndexDefinitionInterface $indexDefinition,
        Request $request,
        TemplateDefinitionInterface $templateDefinition
    ) {
        $request->get('direction', Argument::any())->willReturn('asc');
        $request->get('sort', Argument::any())->willReturn(null);
        $request->get('page', Argument::any())->willReturn(1);

        $indexDefinition->getDefaultSortColumn()->willReturn(null);

        $templateDefinition->getPagination()->shouldBeCalled();
        $templateDefinition->getSortable()->shouldBeCalled();

        $this
            ->getGrid($query, $indexDefinition, $request)
            ->shouldReturnAnInstanceOf('Knp\Component\Pager\Pagination\PaginationInterface')
        ;
    }

    function it_should_set_the_default_if_no_sorting_was_given(
        AbstractQuery $query,
        IndexDefinitionInterface $indexDefinition,
        Request $request,
        TemplateDefinitionInterface $templateDefinition,
        ColumnInterface $sortColumn,
        SlidingPagination $pagination
    ) {
        $request->get('direction', Argument::any())->willReturn('asc');
        $request->get('sort', Argument::any())->willReturn(null);
        $request->get('page', Argument::any())->willReturn(1);
        $indexDefinition->getDefaultSortColumn()->willReturn($sortColumn);
        $indexDefinition->getDefaultSortDirection()->willReturn(IndexDefinitionInterface::SORT_ASC);
        $sortColumn->getField()->willReturn('sortable_field');

        $templateDefinition->getPagination()->shouldBeCalled();
        $templateDefinition->getSortable()->shouldBeCalled();

        $pagination->setParam('sort', 'sortable_field')->shouldBeCalled();
        $pagination->setParam('direction', 'asc')->shouldBeCalled();

        $this
            ->getGrid($query, $indexDefinition, $request)
            ->shouldReturnAnInstanceOf('Knp\Component\Pager\Pagination\PaginationInterface')
        ;
    }

    function it_should_override_default_sorts_with_requested_sorts(
        AbstractQuery $query,
        IndexDefinitionInterface $indexDefinition,
        Request $request,
        TemplateDefinitionInterface $templateDefinition,
        ColumnInterface $sortColumn,
        SlidingPagination $pagination
    ) {
        $request->get('direction', Argument::any())->willReturn('asc');
        $request->get('sort', Argument::any())->willReturn('another_field');
        $request->get('page', Argument::any())->willReturn(1);
        $indexDefinition->getDefaultSortColumn()->willReturn($sortColumn);
        $indexDefinition->getDefaultSortDirection()->willReturn(IndexDefinitionInterface::SORT_ASC);
        $sortColumn->getField()->willReturn('sortable_field');

        $indexDefinition->hasColumnWithField('another_field')->willReturn(true);

        $templateDefinition->getPagination()->shouldBeCalled();
        $templateDefinition->getSortable()->shouldBeCalled();

        $pagination->setParam('sort', Argument::any())->shouldBeCalledTimes(2);
        $pagination->setParam('direction', Argument::any())->shouldBeCalledTimes(2);

        $this
            ->getGrid($query, $indexDefinition, $request)
            ->shouldReturnAnInstanceOf('Knp\Component\Pager\Pagination\PaginationInterface')
        ;
    }

    function it_should_fail_on_an_invalid_sort_column(
        AbstractQuery $query,
        IndexDefinitionInterface $indexDefinition,
        Request $request,
        TemplateDefinitionInterface $templateDefinition
    ) {
        $request->get('direction', Argument::any())->willReturn('asc');
        $request->get('sort', Argument::any())->willReturn('another_field');
        $request->get('page', Argument::any())->willReturn(1);

        $indexDefinition->getDefaultSortColumn()->willReturn(null);

        $indexDefinition->hasColumnWithField('another_field')->willReturn(false);

        $this
            ->shouldThrow('Bs\\CrudifyBundle\\Exception\\CrudifyException')
            ->duringGetGrid($query, $indexDefinition, $request)
        ;
    }
}
