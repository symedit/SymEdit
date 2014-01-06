<?php

namespace SymEdit\Bridge\Widget\Twig\TokenParser;

use SymEdit\Bridge\Widget\Twig\Node\WidgetAreaNode;
use SymEdit\Bundle\WidgetBundle\Twig\TokenParser\WidgetAreaTokenParser as BaseTokenParser;

class WidgetAreaTokenParser extends BaseTokenParser
{
    /**
     * {@inheritDoc}
     */
    protected function getWidgetAreaNode($area, $strategy, $lineno, $tag)
    {
        return new WidgetAreaNode($area, $strategy, $lineno, $tag);
    }
}
