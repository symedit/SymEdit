<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\SymEditBundle\Model\PageInterface; 
use Isometriks\Bundle\SymEditBundle\Widget\Strategy\WidgetStrategyInterface; 

interface WidgetInterface
{
    public function getId(); 
    
    /**
     * @return WidgetInterface
     * @param string $name
     */
    public function setName($name); 
    public function getName(); 
    
    /**
     * @return WidgetInterface
     * @param type $title
     */
    public function setTitle($title); 
    public function getTitle(); 
    
    public function getArea(); 
    
    /**
     * @return WidgetInterface
     * @param \Isometriks\Bundle\SymEditBundle\Model\WidgetAreaInterface $area
     */
    public function setArea(WidgetAreaInterface $area);
    
    /**
     * @return WidgetInterface
     * @param array $options
     */
    public function setOptions(array $options); 
    
    /**
     * @return WidgetInterface
     * @param string $option
     * @param mixed $value
     */
    public function setOption($option, $value); 
    public function getOptions(); 
    public function getOption($option); 
    public function hasOption($option); 
    
    /**
     * @return WidgetInterface
     * @param type $strategyName
     */
    public function setStrategyName($strategyName); 
    public function getStrategyName(); 
    
    /**
     * @return WidgetStrategyInterface $strategy
     */
    public function getStrategy();
    
    /**
     * @return WidgetInterface
     * @param \Isometriks\Bundle\SymEditBundle\Widget\Strategy\WidgetStrategyInterface $strategy
     */
    public function setStrategy(WidgetStrategyInterface $strategy); 
    
    /**
     * @return WidgetInterface
     * @param integer $visibility
     */
    public function setVisibility($visibility); 
    public function getVisibility(); 
    public function isVisible(PageInterface $page); 
    
    /**
     * @return WidgetInterface
     * @param array $assoc
     */
    public function setAssoc(array $assoc); 
    
    /**
     * @return WidgetInterface
     * @param string $assoc
     */
    public function addAssoc($assoc); 
    
    /**
     * @return WidgetInterface
     * @param string $assoc
     */
    public function removeAssoc($assoc); 
    public function getAssoc(); 
    public function hasAssoc(PageInterface $page); 
}