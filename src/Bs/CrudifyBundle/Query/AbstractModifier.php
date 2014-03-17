<?php

namespace Bs\CrudifyBundle\Query;

use Doctrine\ORM\AbstractQuery;
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
    public function modifyQuery(AbstractQuery $query)
    {

    }
}
