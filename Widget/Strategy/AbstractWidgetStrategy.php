<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy; 

use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 

abstract class AbstractWidgetStrategy implements WidgetStrategyInterface
{
    public function setDefaultOptions(WidgetInterface $widget)
    {
    }
}