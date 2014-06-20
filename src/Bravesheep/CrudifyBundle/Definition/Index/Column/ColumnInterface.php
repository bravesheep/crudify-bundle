<?php

namespace Bravesheep\CrudifyBundle\Definition\Index\Column;

use Bravesheep\CrudifyBundle\Definition\Index\IndexDefinitionInterface;

interface ColumnInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|bool
     */
    public function getPath();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getField();

    /**
     * @return string
     */
    public function getTableName();

    /**
     * @return array
     */
    public function getJoinPath();

    /**
     * @param IndexDefinitionInterface $index
     */
    public function setParent(IndexDefinitionInterface $index);

    /**
     * @return IndexDefinitionInterface
     */
    public function getParent();

    /**
     * @return bool
     */
    public function isQueryable();
}
