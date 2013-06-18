<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\SymEditBundle\Model\PageInterface; 
use Isometriks\Bundle\SymEditBundle\Widget\Strategy\WidgetStrategyInterface; 

interface WidgetInterface
{
    public function getId(); 
    
    public function setName($name); 
    public function getName(); 
    
    public function setTitle($title); 
    public function getTitle(); 
    
    public function getArea(); 
    public function setArea(WidgetAreaInterface $area);
    
    public function setOptions(array $options); 
    public function setOption($option, $value); 
    public function getOptions(); 
    public function getOption($option); 
    public function hasOption($option); 
    
    public function setStrategyName($strategyName); 
    public function getStrategyName(); 
    
    /**
     * @return WidgetStrategyInterface $strategy
     */
    public function getStrategy(); 
    public function setStrategy(WidgetStrategyInterface $strategy); 
    
    public function setVisibility($visibility); 
    public function getVisibility(); 
    public function isVisible(PageInterface $page); 
    
    
    public function setAssoc(array $assoc); 
    public function addAssoc($assoc); 
    public function getAssoc(); 
    public function hasAssoc(PageInterface $page); 
}