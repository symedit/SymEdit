<?php

namespace Isometriks\Bundle\SymEditBundle\Iterator;

use Isometriks\Bundle\SymEditBundle\Model\PageInterface;

class RecursivePageIterator implements \RecursiveIterator
{
    private $children;
    private $position;
    private $display;
    
    public function __construct(PageInterface $page, $display = true)
    {
        $this->children = $page->getChildren();
        $this->position = 0;
        $this->display = $display;
    }
    
    /**
     * @return PageInterface
     */
    public function current()
    {
        return $this->children[$this->position];
    }

    public function getChildren()
    {
        return $this->current()->getIterator();
    }

    public function hasChildren()
    {
        return count($this->current()->getChildren()) > 0;
    }

    public function key()
    {
        return $this->current()->getId();
    }

    public function next()
    {
        $this->position++;
        
        while ($this->valid()) {
             if (!$this->display || $this->current()->getDisplay()) {
                 break;
             }
             
             $this->position++;
        }
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->children[$this->position]);
    }
}

