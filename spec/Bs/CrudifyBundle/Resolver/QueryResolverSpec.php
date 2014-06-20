<?php

namespace spec\Bs\CrudifyBundle\Resolver;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bravesheep\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bravesheep\CrudifyBundle\Query\ModifierInterface;
use Bravesheep\CrudifyBundle\Resolver\IdentityResolver;
use Bravesheep\CrudifyBundle\Resolver\QueryModifierResolver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueryResolverSpec extends ObjectBehavior
{
    function let(
        IdentityResolver $identityResolver,
        QueryModifierResolver $queryModifierResolver,
        IndexDefinitionInterface $indexDefinition,
        DefinitionInterface $definition,
        EntityManager $manager,
        QueryBuilder $builder,
        AbstractQuery $query
    ) {
        $this->beConstructedWith($identityResolver, $queryModifierResolver);

        $queryModifierResolver
            ->resolve(Argument::type('Bravesheep\\CrudifyBundle\\Query\\ModifierInterface'))
            ->willReturnArgument()
        ;

        $indexDefinition->getParent()->willReturn($definition);
        $definition->getEntityManager()->willReturn($manager);
        $manager->createQueryBuilder()->willReturn($builder);
        $builder->getQuery()->willReturn($query);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\\CrudifyBundle\\Resolver\\QueryResolver');
    }

    function its_addJoins_should_add_some_joins(
        QueryBuilder $builder
    ) {
        $builder->getDQLPart('select')->willReturn([]);

        $joins = [
            [
                'via' => 'example.test',
                'table' => 'test',
            ]
        ];
        $builder->addSelect('test')->shouldBeCalled();
        $builder->leftJoin('example.test', 'test')->shouldBeCalled();

        $this->addJoins($joins, $builder);
    }

    function its_addJoins_should_not_add_duplicate_joins(
        QueryBuilder $builder,
        Select $select
    ) {
        $builder->getDQLPart('select')->willReturn([$select]);
        $select->getParts()->willReturn(['test']);

        $joins = [
            [
                'via' => 'example.test',
                'table' => 'test',
            ]
        ];
        $builder->addSelect(Argument::any())->shouldNotBeCalled();
        $builder->leftJoin(Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->addJoins($joins, $builder);
    }

    function it_should_select_the_base_entity_named_entity_and_queryable_columns(
        IndexDefinitionInterface $indexDefinition,
        QueryBuilder $builder,
        AbstractQuery $query,
        ColumnInterface $column1,
        ColumnInterface $column2,
        ColumnInterface $column3
    ) {
        $entity = 'AcmeBundle:Test';

        $indexDefinition->getBaseEntity()->willReturn($entity);

        $builder->select('entity')->shouldBeCalled();
        $builder->from($entity, 'entity')->shouldBeCalled();


        $column1->isQueryable()->willReturn(true);
        $column2->isQueryable()->willReturn(false);
        $column3->isQueryable()->willReturn(true);

        $column1->getJoinPath()->shouldBeCalled()->willReturn([]);
        $column2->getJoinPath()->shouldNotBeCalled();
        $column3->getJoinPath()->shouldBeCalled()->willReturn([]);

        $indexDefinition->getColumns()->willReturn([$column1, $column2, $column3]);

        $indexDefinition->getDefaultSortColumn()->willReturn(null);
        $indexDefinition->hasQueryModifier()->willReturn(false);

        $this->resolveQuery($indexDefinition)->shouldReturn($query);
    }

    function it_should_apply_the_default_sort_column(
        IndexDefinitionInterface $indexDefinition,
        QueryBuilder $builder,
        ColumnInterface $column
    ) {
        $entity = 'AcmeBundle:Test';

        $indexDefinition->getBaseEntity()->willReturn($entity);

        $builder->select('entity')->shouldBeCalled();
        $builder->from($entity, 'entity')->shouldBeCalled();

        $indexDefinition->getColumns()->willReturn([]);

        $indexDefinition->getDefaultSortColumn()->willReturn($column);
        $column->getJoinPath()->willReturn([]);
        $column->getField()->willReturn('test');
        $indexDefinition->getDefaultSortDirection()->willReturn(IndexDefinitionInterface::SORT_ASC);

        $builder->addOrderBy('test', 'asc')->shouldBeCalled();

        $indexDefinition->hasQueryModifier()->willReturn(false);

        $this->resolveQuery($indexDefinition);
    }

    function it_should_apply_the_query_modifier(
        IndexDefinitionInterface $indexDefinition,
        QueryBuilder $builder,
        AbstractQuery $query,
        ModifierInterface $modifier
    ) {
        $entity = 'AcmeBundle:Test';
        $indexDefinition->getBaseEntity()->willReturn($entity);
        $builder->select('entity')->shouldBeCalled();
        $builder->from($entity, 'entity')->shouldBeCalled();
        $indexDefinition->getColumns()->willReturn([]);
        $indexDefinition->getDefaultSortColumn()->willReturn(null);

        $indexDefinition->hasQueryModifier()->willReturn(true);
        $indexDefinition->getQueryModifier()->willReturn($modifier);

        $modifier->modifyBuilder($builder)->shouldBeCalled();
        $modifier->modifyQuery($query)->shouldBeCalled();

        $this->resolveQuery($indexDefinition);
    }
}
