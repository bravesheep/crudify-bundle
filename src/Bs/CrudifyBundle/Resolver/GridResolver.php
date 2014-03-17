<?php

namespace Bs\CrudifyBundle\Resolver;

use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Exception\CrudifyException;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

class GridResolver
{
    /**
     * @var Paginator
     */
    private $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param AbstractQuery            $query
     * @param IndexDefinitionInterface $index
     * @param Request                  $request
     * @return PaginationInterface
     */
    public function getGrid(AbstractQuery $query, IndexDefinitionInterface $index, Request $request)
    {
        $sortDirection = $request->get('direction', IndexDefinitionInterface::SORT_ASC);
        $sortColumn = $request->get('sort');

        if (!in_array($sortDirection, [IndexDefinitionInterface::SORT_ASC, IndexDefinitionInterface::SORT_DESC])) {
            throw new CrudifyException("Invalid sorting direction {$sortDirection}");
        }

        if (null !== $sortColumn && !$index->hasColumnWithField($sortColumn)) {
            throw new CrudifyException("No such column '{$sortColumn}' in definition.");
        }

        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate($query, $request->get('page', 1), $index->getObjectsPerPage());

        if (null !== $index->getDefaultSortColumn()) {
            $pagination->setParam('sort', $index->getDefaultSortColumn()->getField());
            $pagination->setParam('direction', $index->getDefaultSortDirection());
        }

        if (null !== $sortColumn) {
            $pagination->setParam('sort', $sortColumn);
            $pagination->setParam('direction', $sortDirection);
        }

        $pagination->setTemplate($index->getParent()->getTemplates()->getPagination());
        $pagination->setSortableTemplate($index->getParent()->getTemplates()->getSortable());
        return $pagination;
    }
}

