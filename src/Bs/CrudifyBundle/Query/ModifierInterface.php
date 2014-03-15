<?php

namespace Bs\CrudifyBundle\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface ModifierInterface
{
    /**
     * Modify the QueryBuilder constructed by the Crudify bundle or return a completely different QueryBuilder.
     * @param QueryBuilder $qb
     * @return QueryBuilder|null
     */
    public function modifyBuilder(QueryBuilder $qb);

    /**
     * Modify the query constructed by the Crudify bundle or return a completely different Query.
     * @param Query $query
     * @return Query|null
     */
    public function modifyQuery(Query $query);
}
