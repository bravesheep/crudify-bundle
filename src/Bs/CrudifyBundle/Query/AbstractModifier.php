<?php

namespace Bs\CrudifyBundle\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractModifier implements ModifierInterface
{
    /**
     * {@inheritdoc}
     */
    public function modifyBuilder(QueryBuilder $qb)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function modifyQuery(Query $query)
    {

    }
}
