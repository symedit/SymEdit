<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Twig\Node;

class WidgetAreaNode extends \Twig_Node
{
    protected $controller = 'symedit.controller.widget_area:renderAreaAction';

    public function __construct($area, $strategy, $lineno, $tag = null)
    {
        parent::__construct(array(), array('area' => $area, 'strategy' => $strategy), $lineno, $tag);
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
            ->write('echo $this->env->getExtension(\'http_kernel\')->renderFragmentStrategy(\''.$this->getAttribute('strategy').'\',')
            ->write('    $this->env->getExtension(\'http_kernel\')')
            ->write('         ->controller(\''.$this->controller.'\', array(')
            ->write('             \'area\' => \''.$this->getAttribute('area').'\',')
            ->write('         ))')
            ->write('    );');
    }
}
