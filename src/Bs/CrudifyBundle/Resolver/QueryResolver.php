<?php

namespace Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Doctrine\ORM\Query\Expr\Select;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class QueryResolver
{
    const BASE_NAME = 'entity';

    /**
     * @var IdentityResolver
     */
    private $identityResolver;

    /**
     * @var QueryModifierResolver
     */
    private $queryModifierResolver;

    public function __construct(IdentityResolver $identityResolver, QueryModifierResolver $queryModifierResolver)
    {
        $this->identityResolver = $identityResolver;
        $this->queryModifierResolver = $queryModifierResolver;
    }

    /**
     * Create a query based on the index definition.
     * @param IndexDefinitionInterface $definition
     * @return Query
     */
    public function resolveQuery(IndexDefinitionInterface $definition)
    {
        $em = $definition->getParent()->getEntityManager();
        $builder = $em->createQueryBuilder();

        $builder->select(self::BASE_NAME);
        $builder->from($definition->getBaseEntity(), self::BASE_NAME);

        $this->addColumns($builder, $definition->getColumns());
        $this->addDefaultSort($builder, $definition);
        return $this->modifyQuery($builder, $definition);
    }

    /**
     * Add the columns in the index to the query
     * @param QueryBuilder      $builder
     * @param ColumnInterface[] $columns
     */
    private function addColumns(QueryBuilder $builder, array $columns)
    {
        /** @var ColumnInterface $column */
        foreach ($columns as $column) {
            if ($column->isQueryable()) {
                $this->addJoins($column->getJoinPath(), $builder);
            }
        }
    }

    /**
     * Add the default sort column to the query
     * @param QueryBuilder             $builder
     * @param IndexDefinitionInterface $definition
     */
    private function addDefaultSort(QueryBuilder $builder, IndexDefinitionInterface $definition)
    {

        if (null !== $definition->getDefaultSortColumn()) {
            $this->addJoins($definition->getDefaultSortColumn()->getJoinPath(), $builder);
            $builder->addOrderBy(
                $definition->getDefaultSortColumn()->getField(),
                $definition->getDefaultSortDirection()
            );
        }
    }

    /**
     * Modify the query with any possible query modifiers.
     * @param QueryBuilder             $builder
     * @param IndexDefinitionInterface $definition
     * @return Query
     */
    private function modifyQuery(QueryBuilder $builder, IndexDefinitionInterface $definition)
    {
        if ($definition->hasQueryModifier()) {
            $modifier = $this->queryModifierResolver->resolve($definition->getQueryModifier());

            $result = $modifier->modifyBuilder($builder);
            if ($result instanceof QueryBuilder) {
                $builder = $result;
            }

            $query = $builder->getQuery();
            $result = $modifier->modifyQuery($query);
            if ($result instanceof Query) {
                $query = $result;
            }
        } else {
            $query = $builder->getQuery();
        }
        return $query;
    }

    /**
     * Add joins to the QueryBuilder
     * @param array        $joins Values should be arrays with 'table' and 'via' keys specifying the join.
     * @param QueryBuilder $qb
     */
    public function addJoins(array $joins, QueryBuilder $qb)
    {
        foreach ($joins as $join) {
            /** @var Select $select */
            foreach ($qb->getDQLPart('select') as $select) {
                if (in_array($join['table'], $select->getParts())) {
                    continue 2; // skip tables that were already joined
                }
            }

            $qb->leftJoin($join['via'], $join['table']);
            $qb->addSelect($join['table']);
        }
    }
}
