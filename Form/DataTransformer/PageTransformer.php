<?php

namespace Isometriks\Bundle\SymEditBundle\Form\DataTransformer; 

use Symfony\Component\Form\DataTransformerInterface; 
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;

class PageTransformer implements DataTransformerInterface
{
    protected $pageManager;
    
    public function __construct(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }
    
    /**
     * Convert to database value
     * 
     * @param type $value
     * @return type
     */
    public function reverseTransform($value)
    {
        return $this->pageManager->find($value);  
    }

    /**
     * Convert to form value 
     * 
     * @param type $value
     */
    public function transform($value)
    {
        if ($value === null) {
            return null;
        }
        
        return $value->getId();
    }    
}