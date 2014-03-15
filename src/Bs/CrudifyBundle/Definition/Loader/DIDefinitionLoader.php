<?php

namespace Bs\CrudifyBundle\Definition\Loader;

use Bs\CrudifyBundle\Definition\Definition;
use Bs\CrudifyBundle\Definition\Form\FormDefinition;
use Bs\CrudifyBundle\Definition\Form\FormDefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\Builder\Registry\BuilderRegistry;
use Bs\CrudifyBundle\Definition\Index\IndexDefinitionInterface;
use Bs\CrudifyBundle\Definition\Registry\DefinitionRegistry;
use Bs\CrudifyBundle\Definition\Template\TemplateDefinition;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\DependencyInjection\ContainerAware;

class DIDefinitionLoader extends ContainerAware
{
    /**
     * @var string[]
     */
    private $templates;

    /**
     * @var BuilderRegistry
     */
    private $indexBuilders;

    /**
     * @var Registry
     */
    private $doctrine;

    public function __construct(Registry $doctrine, BuilderRegistry $indexBuilders)
    {
        $this->doctrine = $doctrine;
        $this->indexBuilders = $indexBuilders;
    }

    /**
     * @param array              $mappings
     * @param DefinitionRegistry $registry
     */
    public function loadAll(array $mappings, DefinitionRegistry $registry)
    {
        foreach ($mappings as $key => $options) {
            $this->load($key, $options, $registry);
        }
    }

    /**
     * Retrieve the templates for the local
     * @param string $template
     * @param array  $local
     * @return string
     */
    private function getTemplate($template, array $local)
    {
        if (array_key_exists($template, $local) && null !== $local[$template]) {
            return $local[$template];
        } else {
            return $this->templates[$template];
        }
    }

    private function getTemplateDefinition(array $templates)
    {
        $definition = new TemplateDefinition();
        $definition->setIndex($this->getTemplate('index', $templates));
        $definition->setNew($this->getTemplate('new', $templates));
        $definition->setEdit($this->getTemplate('edit', $templates));
        $definition->setLayout($this->getTemplate('layout', $templates));
        $definition->setFormTheme($this->getTemplate('form_theme', $templates));
        $definition->setPagination($this->getTemplate('pagination', $templates));
        $definition->setSortable($this->getTemplate('sortable', $templates));
        return $definition;
    }

    public function load($key, array $options, DefinitionRegistry $registry)
    {
        $definition = new Definition(
            $options['entity'],
            $this->doctrine->getManagerForClass($options['entity'])
        );

        $definition->setTemplates($this->getTemplateDefinition($options['templates']));
        $definition->setObjectRetriever($options['object_retriever']);

        $definition->setController($options['controller']);
        $definition->setFlags([
            'create' => $options['create'],
            'update' => $options['update'],
            'delete' => $options['delete'],
        ]);

        $definition->setIndex($this->getIndexDefinition($key, $options));
        $definition->setForm($this->getFormDefinition($options['form'], $options['form_options_provider']));
        $definition->setName($key);
        if (null === $options['title']) {
            $definition->setEntityTitle(ucfirst(str_replace(['-', '_', '.'], ' ', $key)));
        } else {
            $definition->setEntityTitle($options['title']);
        }
        $registry->addDefinition($definition, $key);
    }

    /**
     * @param string $key
     * @param array  $options
     * @return IndexDefinitionInterface
     */
    private function getIndexDefinition($key, array $options)
    {
        $builder = $this->indexBuilders->getBuilder($options['index']['type']);
        return $builder->build([
            'key' => $key,
            'index' => $options['index'],
            'entity' => $options['entity'],
        ]);
    }

    /**
     * @param array $formOptions
     * @return FormDefinitionInterface
     */
    private function getFormDefinition(array $formOptions, $optionsProvider)
    {
        $definition = new FormDefinition($formOptions['create'], $formOptions['update']);
        $definition->setOptionsProvider($optionsProvider);
        return $definition;
    }

    /**
     * @param string[] $templates
     * @return $this
     */
    public function setTemplates(array $templates)
    {
        $this->templates = $templates;
        return $this;
    }
}
