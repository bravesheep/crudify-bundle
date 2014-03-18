<?php

namespace Bs\CrudifyBundle\Definition\Index\Builder;

use Bs\CrudifyBundle\Definition\Index\Column\Column;
use Bs\CrudifyBundle\Definition\Index\IndexDefinition;

class StaticBuilder extends AbstractBuilder
{
    /**
     * {@inheritdoc}
     */
    public function build(array $options)
    {
        $definition = new IndexDefinition();
        foreach ($options['index']['columns'] as $name => $settings) {
            $column = new Column();
            $column->setName($name);
            if (null === $settings['title']) {
                $column->setTitle(ucfirst(str_replace(['-', '_', '.'], ' ', $name)));
            } else {
                $column->setTitle($settings['title']);
            }

            if (null === $settings['path'] || true === $settings['path']) {
                $column->setPath($name);
            } else {
                $column->setPath($settings['path']);
            }
            $column->setType($settings['type']);
            $definition->addColumn($column);
        }

        if (null !== $options['index']['sort']['column']) {
            if ($definition->hasColumn($options['index']['sort']['column'])) {
                $sortColumn = $definition->getColumn($options['index']['sort']['column']);
            } else {
                $sortColumn = new Column();
                $sortColumn->setName($options['index']['sort']['column']);
                $sortColumn->setPath($options['index']['sort']['column']);
            }
            $definition->setDefaultSort($sortColumn, $options['index']['sort']['direction']);
        }
        $definition->setBaseEntity($options['entity']);
        $definition->setObjectsPerPage($options['index']['page_limit']);
        $definition->setQueryModifier($options['index']['query_modifier']);
        return $definition;
    }
}
