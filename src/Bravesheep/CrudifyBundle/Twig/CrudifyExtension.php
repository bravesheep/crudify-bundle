<?php

namespace Bravesheep\CrudifyBundle\Twig;

use Bravesheep\CrudifyBundle\Definition\DefinitionInterface;
use Bravesheep\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bravesheep\CrudifyBundle\Definition\Registry\DefinitionRegistry;
use Bravesheep\CrudifyBundle\Resolver\ControllerResolver;
use Bravesheep\CrudifyBundle\Resolver\LinkResolver;
use Bravesheep\CrudifyBundle\Twig\Node\RenderCrudifyFieldNode;
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class CrudifyExtension extends \Twig_Extension
{
    /**
     * @var PropertyAccessor
     */
    private $accessor;

    /**
     * @var LinkResolver
     */
    private $linkResolver;

    /**
     * @var ControllerResolver
     */
    private $controllerResolver;

    /**
     * @var DefinitionRegistry
     */
    private $definitionRegistry;

    public function __construct(
        PropertyAccessor $accessor,
        LinkResolver $linkResolver,
        ControllerResolver $controllerResolver,
        DefinitionRegistry $definitionRegistry
    ) {
        $this->accessor = $accessor;
        $this->linkResolver = $linkResolver;
        $this->controllerResolver = $controllerResolver;
        $this->definitionRegistry = $definitionRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'crudify';
    }

    public function getFunctions()
    {
        return [
            'crudify_value' => new \Twig_SimpleFunction(
                'crudify_value',
                [$this, 'renderBlock'],
                [
                    'node_class' => 'Bravesheep\CrudifyBundle\Twig\Node\RenderCrudifyFieldNode',
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction('crudify_action', [$this, 'getLinkForAction']),
            new \Twig_SimpleFunction('crudify_delete_form', [$this, 'createDeleteForm']),
            new \Twig_SimpleFunction('crudify_defined', [$this, 'getDefinedMappings']),
            new \Twig_SimpleFunction('crudify_definition', [$this, 'getDefinition']),
        ];
    }

    public function createDeleteForm(DefinitionInterface $definition, $object)
    {
        $controller = $this->controllerResolver->resolve($definition->getController());
        return $controller->createDeleteForm($definition, $object)->createView();
    }

    public function renderBlock(\Twig_Template $template, ColumnInterface $column, $object, $context, $blocks)
    {
        try {
            $value = $this->accessor->getValue($object, $column->getName());
        } catch(ExceptionInterface $exception) {
            $value = null;
        }

        $block = 'crudify_field_' . $column->getType();

        // check if the block exists
        $hasBlock = false;
        if (!isset($blocks[$block])) {
            $current = $template;
            do {
                if ($current->hasBlock($block, $context)) {
                    break;
                }
                $current = $current->getParent($context);
            } while($current instanceof \Twig_Template);
            if ($current instanceof \Twig_Template) {
                $hasBlock = true;
            }
        } else {
            $hasBlock = true;
        }

        if ($hasBlock) {
            $context['value'] = $value;
            $context['definition'] = $column->getParent()->getParent();
            $context['column'] = $column;
            $context['object'] = $object;
            $result = $template->renderBlock($block, $context, $blocks);
        } else {
            $result = htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
        }
        return $result;
    }

    public function getLinkForAction($action, $definition, $object = null)
    {
        if (!($definition instanceof DefinitionInterface)) {
            $definition = $this->definitionRegistry->getDefinition($definition);
        }

        return $this->linkResolver->getLinkForAction($action, $definition, $object);
    }

    public function getDefinedMappings()
    {
        return $this->definitionRegistry->getDefinitions();
    }

    public function getDefinition($name)
    {
        return $this->definitionRegistry->getDefinition($name);
    }
}
