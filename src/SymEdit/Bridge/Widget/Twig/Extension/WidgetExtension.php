<?php

namespace SymEdit\Bridge\Widget\Twig\Extension;

use SymEdit\Bridge\Widget\Twig\TokenParser\WidgetAreaTokenParser;
use SymEdit\Bundle\WidgetBundle\Twig\Extension\WidgetExtension as BaseExtension;

/**
 * Pass in a different TokenParser for SymEdit specific widgets
 */
class WidgetExtension extends BaseExtension
{
    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        return array(
            new WidgetAreaTokenParser($this->strategy),
        );
    }
}