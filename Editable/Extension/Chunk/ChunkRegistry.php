<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk; 

use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 

class ChunkRegistry
{
    private $strategies;
    
    public function injectStrategy(Chunk $chunk)
    {
        $strategy = $this->getStrategy($chunk->getStrategyName()); 
        $chunk->setStrategy($strategy); 
    }
    
    /**
     * @param string $name
     * @return Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface
     * @throws \Exception
     */
    public function getStrategy($name)
    {
        if($this->strategies === null){
            $this->initStrategies(); 
        }
        
        if(isset($this->strategies[$name])){
            return $this->strategies[$name]; 
        }
        
        throw new \Exception(sprintf('Could not find strategy "%s"', $name)); 
    }
    
    private function initStrategies()
    {
        foreach($this->loadStrategies() as $strat){
            if(!$strat instanceof ChunkStrategyInterface){
                throw new \Exception(sprintf('Must implement ChunkStrategyInterface, given %s', get_class($strat))); 
            }

            $this->strategies[$strat->getName()] = $strat; 
        }
    }
    
    public function loadStrategies()
    {
        return array(
            new Strategy\HtmlStrategy(), 
            new Strategy\ImageStrategy(), 
        ); 
    }
}