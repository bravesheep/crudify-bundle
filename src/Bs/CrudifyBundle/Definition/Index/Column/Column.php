<?php

namespace Bs\CrudifyBundle\Definition\Index\Column;

use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Resolver\QueryResolver;

class Column implements ColumnInterface
{
    const TABLE_SEP = '_';

    const NAME_SEP = '.';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|bool
     */
    private $path;

    /**
     * @var IndexDefinitionInterface
     */
    private $parent;

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    protected function getParts()
    {
        return array_merge(
            [QueryResolver::BASE_NAME],
            explode(self::NAME_SEP, $this->getPath())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getField()
    {
        $parts = $this->getParts();
        $name = array_pop($parts);
        $table = implode(self::TABLE_SEP, $parts);
        return "{$table}.{$name}";
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        $parts = $this->getParts();
        array_pop($parts);
        return implode(self::TABLE_SEP, $parts);
    }

    /**
     * {@inheritdoc}
     */
    public function getJoinPath()
    {
        $parts = $this->getParts();
        $size = count($parts);
        $joins = [];

        if ($size > 2) {
            $previous = $parts[0];
            for ($i = 1; $i < $size - 1; $i += 1) {
                $table = implode(self::TABLE_SEP, array_slice($parts, 0, $i + 1));
                $joins[] = [
                    'table' => $table,
                    'via' => "{$previous}.$parts[$i]",
                ];
                $previous = $table;
            }
        }
        return $joins;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(IndexDefinitionInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string|bool $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function isQueryable()
    {
        return is_string($this->path);
    }
}
