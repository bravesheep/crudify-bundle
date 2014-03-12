<?php

namespace Bs\CrudifyBundle\Twig;

use Bs\CrudifyBundle\Definition\DefinitionInterface;
use Bs\CrudifyBundle\Definition\Index\Column\ColumnInterface;
use Bs\CrudifyBundle\Definition\Registry\DefinitionRegistry;
use Bs\CrudifyBundle\Resolver\ControllerResolver;
use Bs\CrudifyBundle\Resolver\LinkResolver;
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
            'crudify_value' => new \Twig_Function_Node(
                'Bs\CrudifyBundle\Twig\Node\RenderCrudifyFieldNode',
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction('crudify_action', [$this, 'getLinkForAction']),
            new \Twig_SimpleFunction('crudify_delete_form', [$this, 'createDeleteForm']),
            new \Twig_SimpleFunction('crudify_defined', [$this, 'getDefinedMappings']),
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
                if ($current->hasBlock($block)) {
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
            $result = \twig_escape_filter($template->getEnvironment(), (string) $value);
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
}
