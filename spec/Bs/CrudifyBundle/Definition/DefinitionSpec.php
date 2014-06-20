<?php

namespace spec\Bs\CrudifyBundle\Definition;

use Bravesheep\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Template\TemplateDefinitionInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefinitionSpec extends ObjectBehavior
{
    private $entity = 'AcmeBundle:Example';

    function let(EntityManager $manager)
    {
        $this->beConstructedWith($this->entity, $manager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bravesheep\CrudifyBundle\Definition\Definition');
    }

    function its_name_is_null_by_default()
    {
        $this->getName()->shouldReturn(null);
    }

    function its_index_is_null_by_default()
    {
        $this->getIndex()->shouldReturn(null);
    }

    function its_form_is_null_by_default()
    {
        $this->getForm()->shouldReturn(null);
    }

    function it_should_not_allow_create_by_default()
    {
        $this->withCreate()->shouldReturn(false);
    }

    function it_should_not_allow_update_by_default()
    {
        $this->withUpdate()->shouldReturn(false);
    }

    function it_should_not_allow_delete_by_default()
    {
        $this->withDelete()->shouldReturn(false);
    }

    function its_entity_should_have_the_constructor_value()
    {
        $this->getEntityName()->shouldReturn($this->entity);
    }

    function its_controller_should_be_null_by_default()
    {
        $this->getController()->shouldReturn(null);
    }

    function its_entityManager_should_have_the_constructor_value(EntityManager $manager)
    {
        $this->getEntityManager()->shouldReturn($manager);
    }

    function its_entityRepository_should_have_the_correct_repository(EntityManager $manager, EntityRepository $repo)
    {
        $manager->getRepository($this->entity)->willReturn($repo);
        $this->getEntityRepository()->shouldReturn($repo);
    }

    function its_entityTitle_should_be_null_by_default()
    {
        return $this->getEntityTitle()->shouldReturn(null);
    }

    function its_objectRetriever_should_be_null_by_default()
    {
        return $this->getObjectRetriever()->shouldReturn(null);
    }

    function its_templates_should_be_null_by_default()
    {
        $this->getTemplates()->shouldReturn(null);
    }

    function its_translationDomain_should_be_messages_by_default()
    {
        $this->getTranslationDomain()->shouldReturn('messages');
    }

    function its_name_should_be_modifyable()
    {
        $this->setName('mapping_name');
        $this->getName()->shouldReturn('mapping_name');
    }

    function its_index_should_be_modifyable(IndexDefinitionInterface $indexDefinition)
    {
        $this->setIndex($indexDefinition);
        $this->getIndex()->shouldReturn($indexDefinition);
    }

    function its_form_should_be_modifyable(FormDefinitionInterface $formDefinition)
    {
        $this->setForm($formDefinition);
        $this->getForm()->shouldReturn($formDefinition);
    }

    function its_flags_should_be_set_for_create()
    {
        $this->setFlags([
            'create' => true,
            'update' => false,
            'delete' => false,
        ]);
        $this->withCreate()->shouldReturn(true);
    }

    function its_flags_should_be_set_for_update()
    {
        $this->setFlags([
            'create' => false,
            'update' => true,
            'delete' => false,
        ]);
        $this->withUpdate()->shouldReturn(true);
    }

    function its_flags_should_be_set_for_delete()
    {
        $this->setFlags([
            'create' => false,
            'update' => false,
            'delete' => true,
        ]);
        $this->withDelete()->shouldReturn(true);
    }

    function its_entity_should_be_modifyable()
    {
        $this->setEntity('AcmeBundle:AnotherEntity');
        $this->getEntityName()->shouldReturn('AcmeBundle:AnotherEntity');
    }

    function its_controller_should_be_modifyable()
    {
        $this->setController('my_controller_service');
        $this->getController()->shouldReturn('my_controller_service');
    }

    function its_entityManager_should_be_modifyable(
        EntityManager $manager,
        EntityManager $otherManager,
        EntityRepository $repo
    ) {
        $manager->getRepository($this->entity)->shouldNotBeCalled();
        $otherManager->getRepository($this->entity)->shouldBeCalled()->willReturn($repo);

        $this->setEntityManager($otherManager);
        $this->getEntityManager()->shouldReturn($otherManager);
        $this->getEntityRepository()->shouldReturn($repo);
    }

    function its_entityTitle_should_be_modifyable()
    {
        $this->setEntityTitle('Some title');
        $this->getEntitytitle()->shouldReturn('Some title');
    }

    function its_objectRetriever_should_be_modifyable()
    {
        $this->setObjectRetriever('my_object_retriever_service');
        $this->getObjectRetriever()->shouldReturn('my_object_retriever_service');
    }

    function its_templates_should_be_modifyable(TemplateDefinitionInterface $templateDefinition)
    {
        $this->setTemplates($templateDefinition);
        $this->getTemplates()->shouldReturn($templateDefinition);
    }

    function its_translationDomain_should_be_modifyable()
    {
        $this->setTranslationDomain('crudify');
        $this->getTranslationDomain()->shouldReturn('crudify');
    }
}
