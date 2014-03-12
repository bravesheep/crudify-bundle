<?php

namespace Bs\CrudifyBundle\Twig\Node;

use Twig_Compiler;

class RenderCrudifyFieldNode extends \Twig_Node_Expression_Function
{
    public function compile(Twig_Compiler $compiler)
    {
        $arguments = iterator_to_array($this->getNode('arguments'));
        if (count($arguments) !== 2) {
            throw new \Twig_Error_Syntax("crudify_value requires ColumnInterface and object");
        }

        $compiler
            ->raw("\$this->env->getExtension('crudify')->renderBlock(\$this, ")
            ->subcompile($arguments[0])
            ->raw(", ")
            ->subcompile($arguments[1])
            ->raw(", \$context, \$blocks)")
        ;
    }
}
