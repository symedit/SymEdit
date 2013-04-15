<?php

namespace Isometriks\Bundle\SymEditBundle\Annotation;

/**
 * @Annotation
 */
class PageController
{
    private $name;
    private $default; 

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $key;
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf("Unknown property '%s' on annotation '%s'.", $key, get_class($this)));
            }
            $this->$method($value);
        }
    }
    
    public function setDefault($default)
    {
        $this->default = $default; 
    }
    
    public function getDefault()
    {
        return $this->default; 
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}