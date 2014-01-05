<?php

namespace SymEdit\Bundle\SettingsBundle\Loader; 

use SymEdit\Bundle\SettingsBundle\Exception\DuplicateSettingException; 

class GroupData
{
    private $name; 
    private $label; 
    private $settings = array(); 
    private $default_options; 
    private $role; 
    
    public function __construct($name, $label, array $default_options = array(), $role = null)
    {
        $this->name = $name; 
        $this->label = $label; 
        $this->default_options = $default_options; 
        $this->role = $role; 
    }
    
    public function getName()
    {
        return $this->name; 
    }
    
    public function getLabel()
    {
        return $this->label; 
    }
    
    public function getDefaultOptions()
    {
        return $this->default_options; 
    }
    
    public function getRole()
    {
        return $this->role; 
    }
    
    public function addSetting( SettingData $setting )
    {
        if(isset($this->settings[$setting->getName()])){
            throw new DuplicateSettingException($this->getName(), $setting->getName()); 
        }
        
        $this->settings[$setting->getName()] = $setting; 
    }
    
    public function getSettings()
    {
        return $this->settings; 
    }
}