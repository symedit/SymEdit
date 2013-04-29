<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface; 

abstract class Chunk implements ChunkInterface
{ 
    const SELF = 1; 
    const PARENT = 2; 
    const ROOT = 3; 
    
    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var string Chunk Name
     */
    protected $name; 
    
    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $strategyName;
    
    /**
     * @var \Isometriks\Bundle\SymEditBundle\Model\PageInterface
     */
    protected $page; 
    
    /**
     * @var string
     */
    protected $strategy; 

    public function __construct()
    {
        $this->setOptions(array()); 
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name; 
        
        return $this; 
    }
    
    public function getName()
    {
        return $this->name; 
    }

    /**
     * Set options
     *
     * @param array $options
     * @return ChunkInterface
     */
    public function setOptions($options)
    {
        $this->options = $options;
    
        return $this;
    }
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $value; 
        
        return $this; 
    }

    /**
     * Get options
     *
     * @return array 
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    public function getOption($option)
    {
        return $this->options[$option]; 
    }
    
    public function hasOption($option)
    {
        return isset($this->options[$option]); 
    }

    /**
     * Set strategyClassName
     *
     * @param string $strategyClassName
     * @return ChunkInterface
     */
    public function setStrategyName($strategyName)
    {
        $this->strategyName = $strategyName;
    
        return $this;
    }

    /**
     * Get strategyClassName
     *
     * @return string 
     */
    public function getStrategyName()
    {
        return $this->strategyName;
    }
    
    /**
     * Get Strategy Instance
     * @return \Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface
     */
    public function getStrategy()
    {
        return $this->strategy; 
    }
    
    public function setStrategy(ChunkStrategyInterface $strategy)
    {
        $this->strategy = $strategy; 
        $this->strategyName = $strategy->getName(); 
    }
    
    public function setPage(PageInterface $page)
    {
        $this->page = $page; 
        
        return $this; 
    }
    
    /**
     * @return \Isometriks\Bundle\SymEditBundle\Model\PageInterface $page
     */
    public function getPage()
    {
        return $this->page; 
    }
}