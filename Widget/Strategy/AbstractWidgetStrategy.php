<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy; 

use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractWidgetStrategy implements WidgetStrategyInterface
{
    /**
     * @var EngineInterface
     */
    protected $templating;
    
    public function setDefaultOptions(WidgetInterface $widget)
    {
    }
    
    public function buildForm(FormBuilderInterface $builder)
    {
    }
    
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }
    
    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }
    
    public function render($name, array $parameters = array())
    {
        return $this->templating->render($name, $parameters);
    }
}