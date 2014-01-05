<?php

namespace SymEdit\Bundle\CoreBundle\Twig\Extension;

use SymEdit\Bundle\CoreBundle\Twig\TokenParser;

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