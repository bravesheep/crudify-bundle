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
        $qb = $em->createQueryBuilder();

        $qb->select(self::BASE_NAME);
        $qb->from($definition->getBaseEntity(), self::BASE_NAME);

        /** @var ColumnInterface $column */
        foreach ($definition as $column) {
            if ($column->isQueryable()) {
                $this->addJoins($column->getJoinPath(), $qb);
            }
        }

        // add default ordering
        if (null !== $definition->getDefaultSortColumn()) {
            $this->addJoins($definition->getDefaultSortColumn()->getJoinPath(), $qb);
            $qb->addOrderBy($definition->getDefaultSortColumn()->getField(), $definition->getDefaultSortDirection());
        }

        // modify the query using the query modifier
        if ($definition->hasQueryModifier()) {
            $modifier = $this->queryModifierResolver->resolve($definition->getQueryModifier());

            $modifier->modifyBuilder($qb);
            $query = $qb->getQuery();
            $modifier->modifyQuery($query);
        } else {
            $query = $qb->getQuery();
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
