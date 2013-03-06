<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy\ChunkStrategyInterface; 
use Isometriks\Bundle\SymEditBundle\Entity\Page; 

/**
 * Chunk
 *
 * @ORM\Table(name="chunk")
 * @ORM\Entity
 */
class Chunk
{
    
    const SELF = 1; 
    const PARENT = 2; 
    const ROOT = 3; 
    
    public function __construct()
    {
        $this->setOptions(array()); 
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var string Chunk Name
     * 
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name; 
    
    /**
     * @var array
     *
     * @ORM\Column(name="options", type="json_array")
     */
    private $options;

    /**
     * @var string
     *
     * @ORM\Column(name="strategy_name", type="string", length=255)
     */
    private $strategyName;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="chunks")
     */
    private $page; 
    
    private $strategy; 


    /**
     * Get id
     *
     * @return integer 
     */
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
     * @return Chunk
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
     * @return Chunk
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
    
    public function setPage(Page $page)
    {
        $this->page = $page; 
        
        return $this; 
    }
    
    /**
     * 
     * @return Page page object tied to chunk
     */
    public function getPage()
    {
        return $this->page; 
    }
}
