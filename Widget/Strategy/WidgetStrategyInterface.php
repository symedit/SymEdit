<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy; 

use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 

interface WidgetStrategyInterface
{
    public function getName(); 
    public function getDescription(); 
    
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     */
    public function buildForm(FormBuilderInterface $builder); 
    
    public function execute(WidgetInterface $widget); 
    
    public function setDefaultOptions(WidgetInterface $widget); 
}