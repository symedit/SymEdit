<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Templating\EngineInterface;

interface WidgetStrategyInterface
{
    public function getName(); 
    public function getDescription(); 
    
    /**
     * @param FormBuilderInterface $builder
     */
    public function buildForm(FormBuilderInterface $builder); 
    
    public function execute(WidgetInterface $widget, PageInterface $page = null); 
    
    public function setDefaultOptions(WidgetInterface $widget); 
    
    /**
     * @return EngineInterface
     */    
    public function getTemplating();
    
    public function setTemplating(EngineInterface $templating);
    
    /**
     * @param string $name Template name
     * @param array $parameters Template parameters
     */
    public function render($name, array $parameters = array());     
}