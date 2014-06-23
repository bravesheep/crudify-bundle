<?php

namespace Bravesheep\CrudifyBundle\Definition\Index\Builder;

use Bravesheep\CrudifyBundle\Definition\Index\Column\Column;
use Bravesheep\CrudifyBundle\Definition\Index\IndexDefinition;

abstract class AbstractBuilder implements BuilderInterface
{
    /**
     * @param array $options
     * @return IndexDefinition
     */
    public function build(array $options)
    {
        $definition = new IndexDefinition();
        $definition->setBaseEntity($options['entity']);
        $definition->setObjectsPerPage($options['index']['page_limit']);
        $definition->setQueryModifier($options['index']['query_modifier']);
        return $definition;
    }

    protected function setSortColumn(IndexDefinition $definition, $column, $direction)
    {
        if ($definition->hasColumn($column)) {
            $sortColumn = $definition->getColumn($column);
        } else {
            $sortColumn = new Column();
            $sortColumn->setName($column);
            $sortColumn->setPath($column);
        }
        $definition->setDefaultSort($sortColumn, $direction);
    }

    protected function titlize($str)
    {
        return ucfirst(str_replace(['-', '_', '.'], ' ', $str));
    }
}
