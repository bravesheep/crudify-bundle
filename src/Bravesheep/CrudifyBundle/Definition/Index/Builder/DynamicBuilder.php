<?php

namespace Bravesheep\CrudifyBundle\Definition\Index\Builder;

use Bravesheep\CrudifyBundle\Definition\Index\Column\Column;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DynamicBuilder extends AbstractBuilder
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function build(array $options)
    {
        $definition = parent::build($options);

        // TODO: add columns
        $em = $this->doctrine->getManagerForClass($options['entity']);
        $metadata = $em->getClassMetadata($options['entity']);

        //var_dump($metadata);
        //var_dump($options);

        foreach ($metadata->getFieldNames() as $field) {
            $type = $metadata->getTypeOfField($field);

            $column = new Column();
            $column->setName($field);
            $column->setTitle($this->titlize($field));
            $column->setPath($field);

            if (in_array($type, ['string', 'integer', 'smallint', 'bigint', 'decimal', 'float'])) {
                $column->setType('text');
                $definition->addColumn($column);
            }

            if (in_array($type, ['date', 'time', 'datetime', 'datetimetz'])) {
                $column->setType($type);
                $definition->addColumn($column);
            }

            if ($type === 'boolean') {
                $column->setType('bool');
                $definition->addColumn($column);
            }
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
