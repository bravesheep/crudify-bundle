<?php

namespace Bravesheep\CrudifyBundle\Query;

use Doctrine\ORM\AbstractQuery;
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
     * @param AbstractQuery $query
     * @return AbstractQuery|null
     */
    public function modifyQuery(AbstractQuery $query);
}
