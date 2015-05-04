<?php

namespace Bravesheep\CrudifyBundle\Definition\Index;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bravesheep\CrudifyBundle\Exception\ColumnNotFoundException;
use Bravesheep\CrudifyBundle\Query\ModifierInterface;

class IndexDefinition implements IndexDefinitionInterface
{
    /**
     * @var ColumnInterface[]
     */
    private $columns;

    /**
     * @var ColumnInterface
     */
    private $defaultSortColumn;

    /**
     * @var string
     */
    private $defaultSortDirection;

    /**
     * @var string
     */
    private $baseEntity;

    /**
     * @var DefinitionInterface
     */
    private $parent;

    /**
     * @var int
     */
    private $objectsPerPage;

    /**
     * @var string|ModifierInterface
     */
    private $queryModifier;

    public function __construct()
    {
        $this->columns = [];
        $this->defaultSortDirection = self::SORT_ASC;
        $this->objectsPerPage = -1;
    }

    /**
     * {@inheritdoc}
     */
    public function addColumn(ColumnInterface $column)
    {
        $this->columns[] = $column;
        $column->setParent($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * {@inheritdoc}
     */
    public function hasColumn($name)
    {
        foreach ($this->columns as $column) {
            if ($column->getName() === $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($name)
    {
        foreach ($this->columns as $column) {
            if ($column->getName() === $name) {
                return $column;
            }
        }
        throw new ColumnNotFoundException("No column with name '{$name}' found");
    }

    /**
     * @param ColumnInterface $column
     * @param string          $direction
     */
    public function setDefaultSort(ColumnInterface $column, $direction = self::SORT_ASC)
    {
        $this->defaultSortColumn = $column;
        $this->defaultSortDirection = $direction;
        $column->setParent($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSortColumn()
    {
        return $this->defaultSortColumn;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSortDirection()
    {
        return $this->defaultSortDirection;
    }

    /**
     * @param string $baseEntity
     * @return $this
     */
    public function setBaseEntity($baseEntity)
    {
        $this->baseEntity = $baseEntity;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseEntity()
    {
        return $this->baseEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(DefinitionInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param int $objectsPerPage
     * @return $this
     */
    public function setObjectsPerPage($objectsPerPage)
    {
        $this->objectsPerPage = $objectsPerPage;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectsPerPage()
    {
        return $this->objectsPerPage;
    }

    /**
     * {@inheritdoc}
     */
    public function hasColumnWithField($field)
    {
       return $this->getColumnWithField($field) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnWithField($field)
    {
        /** @var ColumnInterface $column */
        foreach ($this as $column) {
            if ($column->getField() === $field) {
                return $column;
            }
        }
        return null;
    }

    /**
     * @param ModifierInterface|string $queryModifier
     * @return $this
     */
    public function setQueryModifier($queryModifier)
    {
        $this->queryModifier = $queryModifier;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryModifier()
    {
        return $this->queryModifier;
    }

    /**
     * {@inheritdoc}
     */
    public function hasQueryModifier()
    {
        return null !== $this->queryModifier;
    }
}
