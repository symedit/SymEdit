<?php

namespace SymEdit\Bundle\SettingsBundle\Loader; 

class SettingData
{
    private $name; 
    private $type; 
    private $options; 
    private $default; 
    
    public function __construct($name, $default = '', $type = 'text', array $options = array())
    {
        $this->name    = $name; 
        $this->type    = $type; 
        $this->options = $options; 
        $this->default = $default; 
    }
    
    public function getName()
    {
        return $this->name; 
    }
    
    public function setName($name)
    {
        $this->name = $name; 
    }
    
    public function getType()
    {
        return $this->type; 
    }
    
    public function setType($type)
    {
        $this->type = $type; 
    }
    
    public function getOptions()
    {
        return $this->options; 
    }
    
    public function setOptions(array $options)
    {
        $this->options = $options; 
    }
    
    public function getDefault()
    {
        return $this->default; 
    }
    
    public function setDefault($default)
    {
        $this->default = $default; 
    }
}