<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Extension; 

use Isometriks\Bundle\SymEditBundle\Twig\TokenParser;

class WidgetExtension extends \Twig_Extension
{    
    
    public function getTokenParsers()
    {
        return array(
            new TokenParser\WidgetAreaTokenParser(), 
        ); 
    }
    
    public function getName()
    {
        return 'symedit_widget'; 
    }    
}