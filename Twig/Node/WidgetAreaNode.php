<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Node; 

class WidgetAreaNode extends \Twig_Node
{
    public function __construct($area, $lineno, $tag = null)
    {
        parent::__construct(array(), array('area' => $area), $lineno, $tag); 
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
            ->write('echo $this->env->getExtension(\'http_kernel\')->renderFragmentStrategy(\'esi\',')
            ->write('    $this->env->getExtension(\'http_kernel\')')
            ->write('         ->controller(\'IsometriksSymEditBundle:Widget:renderArea\', array(')
            ->write('             \'area\' => \'' . $this->getAttribute('area') . '\',')
            ->write('             \'_page_id\' => $context[\'Page\']->getId(),')
            ->write('         ))')
            ->write('    );'); 
    }
}