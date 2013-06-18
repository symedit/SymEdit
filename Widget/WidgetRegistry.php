<?php

namespace Isometriks\Bundle\SymEditBundle\Widget; 

use Symfony\Component\DependencyInjection\ContainerAware; 
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 

class WidgetRegistry extends ContainerAware
{
    private $strategies; 
    
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
        foreach($this->strategies as $key=>$strategy){
            if(is_string($strategy)){
                $strategy = $this->container->get($strategy); 
                $this->strategies[$key] = $strategy; 
            }
            
            if($strategy->getName() === $name){
                return $strategy; 
            }
        }
        
        throw new \Exception(sprintf('Could not find strategy "%s".', $name)); 
    }
    
    public function injectStrategy(WidgetInterface $widget)
    {
        $strategy = $this->getStrategy($widget->getStrategyName()); 
        $widget->setStrategy($strategy); 
    }
}