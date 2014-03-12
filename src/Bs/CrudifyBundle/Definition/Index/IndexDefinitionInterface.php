<?php

namespace Bs\CrudifyBundle\Definition\Index;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bs\CrudifyBundle\Exception\ColumnNotFoundException;
use Bs\CrudifyBundle\Query\ModifierInterface;

interface IndexDefinitionInterface extends \IteratorAggregate, \Countable
{
    const SORT_ASC = 'asc';

    const SORT_DESC = 'desc';

    /**
     * @param ColumnInterface $column
     * @return $this
     */
    public function addColumn(ColumnInterface $column);

    /**
     * Retrieve the list of columns.
     * @return ColumnInterface[]
     */
    public function getColumns();

    /**
     * Retrieve the column with a given name.
     * @param string $name
     * @return ColumnInterface
     * @throws ColumnNotFoundException
     */
    public function getColumn($name);

    /**
     * Whether or not a column with the given name exists.
     * @param string $name
     * @return bool
     */
    public function hasColumn($name);

    /**
     * The column on which sorting should take place by default.
     * @return ColumnInterface
     */
    public function getDefaultSortColumn();

    /**
     * Returns asc or desc for the direction of the default sorting.
     * @return string
     */
    public function getDefaultSortDirection();

    /**
     * The name of the entity that should serve as the root for retrieving properties in columns.
     * @return string
     */
    public function getBaseEntity();

    /**
     * @return DefinitionInterface
     */
    public function getParent();

    /**
     * @param DefinitionInterface $definition
     */
    public function setParent(DefinitionInterface $definition);

    /**
     * Retrieve the number of objects shown on the index per page.
     * @return int
     */
    public function getObjectsPerPage();

    /**
     * @return bool
     */
    public function hasColumnWithField($field);

    /**
     * @return ModifierInterface
     */
    public function getQueryModifier();

    /**
     * @return bool
     */
    public function hasQueryModifier();
}
