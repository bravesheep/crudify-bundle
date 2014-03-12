<?php

namespace Bs\CrudifyBundle\Definition;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

interface DefinitionInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return IndexDefinitionInterface
     */
    public function getIndex();

    /**
     * @return FormDefinitionInterface
     */
    public function getForm();

    /**
     * @return string
     */
    public function getEntityName();

    /**
     * @return bool
     */
    public function withCreate();

    /**
     * @return bool
     */
    public function withUpdate();

    /**
     * @return bool
     */
    public function withDelete();

    /**
     * @return CrudControllerInterface
     */
    public function getController();

    /**
     * @return string
     */
    public function getIndexTemplate();

    /**
     * @return string
     */
    public function getNewTemplate();

    /**
     * @return string
     */
    public function getEditTemplate();

    /**
     * @return string
     */
    public function getFormThemeTemplate();

    /**
     * @return string
     */
    public function getPaginationTemplate();

    /**
     * @return string
     */
    public function getSortableTemplate();

    /**
     * @return EntityManager
     */
    public function getEntityManager();

    /**
     * @return EntityRepository
     */
    public function getEntityRepository();

    /**
     * @return string
     */
    public function getLayout();

    /**
     * @return string
     */
    public function getEntityTitle();

    /**
     * @return string
     */
    public function getObjectRetriever();
}
