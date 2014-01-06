<?php

namespace SymEdit\Bundle\WidgetBundle\Twig\Extension;

use SymEdit\Bundle\WidgetBundle\Twig\TokenParser;

class WidgetExtension extends \Twig_Extension
{
    protected $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function getTokenParsers()
    {
        return array(
            new TokenParser\WidgetAreaTokenParser($this->strategy),
        );
    }
    
    public function getName()
    {
        return 'symedit_widget';
    }
}