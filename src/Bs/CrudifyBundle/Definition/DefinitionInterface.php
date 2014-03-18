<?php

namespace Bs\CrudifyBundle\Definition;

use Bs\CrudifyBundle\Controller\CrudControllerInterface;
use Bs\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Definition\Template\TemplateDefinitionInterface;
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
    public function getEntityTitle();

    /**
     * @return string
     */
    public function getObjectRetriever();

    /**
     * @return TemplateDefinitionInterface
     */
    public function getTemplates();

    /**
     * @return string
     */
    public function getTranslationDomain();
}
