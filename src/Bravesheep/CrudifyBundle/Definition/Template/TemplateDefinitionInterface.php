<?php

namespace Bravesheep\CrudifyBundle\Definition\Template;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

interface TemplateDefinitionInterface
{
    /**
     * @return string
     */
    public function getLayout();

    /**
     * @return string
     */
    public function getIndex();

    /**
     * @return string
     */
    public function getNew();

    /**
     * @return string
     */
    public function getEdit();

    /**
     * @return string
     */
    public function getFormTheme();

    /**
     * @return string
     */
    public function getPagination();

    /**
     * @return string
     */
    public function getSortable();

    /**
     * @return DefinitionInterface
     */
    public function getParent();

    /**
     * @param DefinitionInterface $definition
     * @return $this
     */
    public function setParent(DefinitionInterface $definition);
}
