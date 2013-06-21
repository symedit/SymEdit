<?php

namespace Isometriks\Bundle\SymEditBundle\Widget; 

use Symfony\Component\DependencyInjection\ContainerAware; 
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Isometriks\Bundle\SymEditBundle\Widget\Strategy\WidgetStrategyInterface; 

class WidgetRegistry extends ContainerAware
{
    private $strategies;
    private $loadedStrategies; 
    
    /**
     * @TODO: Force users to add a "name" attribute to the strategy in the container
     *        This will allow us to lookup in O(1) instead since we can have
     *        an associative array instead and not instantiate extra classes. 
     * 
     * 
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $strategies
     */
    public function __construct(ContainerInterface $container, array $strategies)
    {
        $this->setContainer($container); 
        $this->strategies = $strategies; 
    }
    
    /**
     * @param string $name Strategy Name
     * @return Isometriks\Bundle\SymEditBundle\Widget\Strategy\WidgetStrategyInterface
     * @throws \Exception
     */
    public function getStrategy($name)
    {
        if(!isset($this->loadedStrategies[$name])){
            $this->loadStrategy($name); 
        }
        
        return $this->loadedStrategies[$name];  
    }
    
    private function loadStrategy($name)
    {
        foreach($this->strategies as $key=>$id){
            $strategy = $this->loadKey($key);  
            
            if($strategy->getName() === $name){
                return; 
            }
        }
        
        throw new \Exception(sprintf('Could not find strategy "%s".', $name)); 
    }
    
    private function loadKey($key)
    {
        $id = $this->strategies[$key]; 
        $strategy = $this->container->get($id); 
        
        if(!$strategy instanceof WidgetStrategyInterface){
            throw new \Exception('Widgets must implement WidgetStrategyInterface'); 
        }
        
        $this->loadedStrategies[$strategy->getName()] = $strategy; 
        
        unset($this->strategies[$key]); 
        
        return $strategy; 
    }
    
    /**
     * 
     * @return WidgetStrategyInterface
     */
    public function getStrategies()
    {
        foreach($this->strategies as $key=>$id){
            $this->loadKey($key); 
        }
        
        return $this->loadedStrategies; 
    }
    
    public function injectStrategy(WidgetInterface $widget)
    {
        $strategy = $this->getStrategy($widget->getStrategyName()); 
        $widget->setStrategy($strategy); 
    }
    
    /**
     * Initiates the Widget with the strategy default options
     * 
     * @param \Isometriks\Bundle\SymEditBundle\Model\WidgetInterface $widget
     */
    public function init(WidgetInterface $widget)
    {
        $this->injectStrategy($widget); 
        $widget->getStrategy()->setDefaultOptions($widget); 
    }
}