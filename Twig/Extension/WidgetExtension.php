<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Extension;

use Isometriks\Bundle\SymEditBundle\Twig\TokenParser;

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
        return 'isometriks_symedit_widget';
    }
}