<?php

namespace Bravesheep\CrudifyBundle\Definition\Template;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;

class TemplateDefinition implements TemplateDefinitionInterface
{
    /**
     * @var string
     */
    private $index;

    /**
     * @var string
     */
    private $new;

    /**
     * @var string
     */
    private $edit;

    /**
     * @var string
     */
    private $formTheme;

    /**
     * @var string
     */
    private $pagination;

    /**
     * @var string
     */
    private $sortable;

    /**
     * @var string
     */
    private $layout;

    /**
     * @var DefinitionInterface
     */
    private $parent;

    /**
     * @param string $edit
     * @return $this
     */
    public function setEdit($edit)
    {
        $this->edit = $edit;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEdit()
    {
        return $this->edit;
    }

    /**
     * @param string $formTheme
     * @return $this
     */
    public function setFormTheme($formTheme)
    {
        $this->formTheme = $formTheme;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormTheme()
    {
        return $this->formTheme;
    }

    /**
     * @param string $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $new
     * @return $this
     */
    public function setNew($new)
    {
        $this->new = $new;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @param string $pagination
     * @return $this
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @return string
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(DefinitionInterface $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $sortable
     * @return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSortable()
    {
        return $this->sortable;
    }
}
