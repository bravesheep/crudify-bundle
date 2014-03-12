<?php

namespace Bs\CrudifyBundle\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface ModifierInterface
{
    /**
     * @param QueryBuilder $qb
     */
    public function modifyBuilder(QueryBuilder $qb);

    /**
     * @param Query $query
     */
    public function modifyQuery(Query $query);
}
