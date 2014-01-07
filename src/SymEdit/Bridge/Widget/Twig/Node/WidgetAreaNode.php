<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bridge\Widget\Twig\Node;

use SymEdit\Bundle\WidgetBundle\Twig\Node\WidgetAreaNode as BaseNode;

/**
 * Renders the WidgetAreaNode with the current Page context which is sometimes
 * needed for SymEdit
 */
class WidgetAreaNode extends BaseNode
{
    /**
     * {@inheritDoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('echo $this->env->getExtension(\'http_kernel\')->renderFragmentStrategy(\'' . $this->getAttribute('strategy') . '\',')
            ->write('    $this->env->getExtension(\'http_kernel\')')
            ->write('         ->controller(\'SymEditBundle:Widget:renderArea\', array(')
            ->write('             \'area\' => \'' . $this->getAttribute('area') . '\',')
            ->write('             \'path\' => $context[\'Page\']->getPath(),')
            ->write('             \'_page_id\'   => is_numeric($context[\'Page\']->getId()) ? $context[\'Page\']->getId() : \'\',')
            ->write('         ))')
            ->write('    );');
    }
}