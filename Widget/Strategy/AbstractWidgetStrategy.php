<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy; 

use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 

abstract class AbstractWidgetStrategy implements WidgetStrategyInterface
{
    public function setDefaultOptions(WidgetInterface $widget)
    {
    }
    
    public function buildForm(FormBuilderInterface $builder)
    {
    }
}