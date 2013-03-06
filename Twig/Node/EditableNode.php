<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Node; 

class EditableNode extends \Twig_Node
{
    public function __construct($subject, $type, \Twig_Node_Expression $parameters, $lineno, $tag = null)
    {
        parent::__construct(array('subject' => $subject, 'parameters' => $parameters), array('type' => $type), $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write("echo \$this->env->getExtension('symedit_editable')->render(")
            ->subcompile($this->getNode('subject'))
            ->raw(", '" . $this->getAttribute('type') . "', ")
            ->subcompile($this->getNode('parameters'))
            ->raw(");\n")
        ;
    }
}