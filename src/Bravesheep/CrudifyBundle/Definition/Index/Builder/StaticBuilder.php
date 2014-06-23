<?php

namespace Bravesheep\CrudifyBundle\Definition\Index\Builder;

use Bravesheep\CrudifyBundle\Definition\Index\Column\Column;

class StaticBuilder extends AbstractBuilder
{
    /**
     * {@inheritdoc}
     */
    public function build(array $options)
    {
        $definition = parent::build($options);

        foreach ($options['index']['columns'] as $name => $settings) {
            $column = new Column();
            $column->setName($name);
            if (null === $settings['title']) {
                $column->setTitle($this->titlize($name));
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
            $this->setSortColumn(
                $definition,
                $options['index']['sort']['column'],
                $options['index']['sort']['direction']
            );
        }

        return $definition;
    }
}
