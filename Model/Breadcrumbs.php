<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

class Breadcrumbs implements BreadcrumbsInterface
{
    protected $crumbs = array(); 
    
    public function all()
    {
        return $this->crumbs; 
    }
    
    public function unshift($title, $path, $params = array())
    {
        array_unshift($this->crumbs, array(
            'title' => $title, 
            'path' => $path, 
            'params' => $params, 
        )); 
    }

    public function pop()
    {
        return array_pop($this->crumbs); 
    }

    public function push($title, $path, $params = array())
    {
        $this->crumbs[] = array(
            'title' => $title, 
            'path' => $path, 
            'params' => $params, 
        ); 
    }
    
    public function getIterator()
    {
        return new \ArrayIterator($this->crumbs); 
    }

    public function count()
    {
        return count($this->crumbs); 
    }
}