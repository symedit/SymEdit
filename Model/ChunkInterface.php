<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface; 

interface ChunkInterface
{
    public function getId(); 
    
    public function setName($name); 
    public function getName(); 
    
    public function setOptions($options); 
    public function setOption($name, $value); 
    public function getOptions(); 
    public function getOption($name); 
    public function hasOption($name); 
    
    public function setStrategyName($strategyName); 
    public function getStrategyName(); 
    
    public function getStrategy(); 
    public function setStrategy(ChunkStrategyInterface $strategy); 
    
    public function setPage(PageInterface $page); 
    public function getPage(); 
}