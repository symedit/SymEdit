<?php

namespace Isometriks\Bundle\SettingsBundle\Loader; 

class ConfigData
{
    private $groups; 
    
    public function hasGroup($name)
    {
        return isset($this->groups[$name]); 
    }
    
    public function createGroup($name, $label, array $default_options = array(), $role = null)
    {
        $group = new GroupData($name, $label, $default_options, $role); 
        $this->addGroup($group); 
        
        return $group; 
    }
    
    public function addGroup(GroupData $group)
    {
        if($this->hasGroup($group->getName())){
            throw new \Exception('Adding group that already exists, you can add more settings to a group, but you cannot add a group name twice'); 
        }
         
        $this->groups[$group->getName()] = $group; 
    }
    
    public function getGroups()
    {
        return $this->groups; 
    }
    
    public function getGroup($name)
    {
        if(!$this->hasGroup($name)){
            throw new \Exception(sprintf('Group "%s" not found', $name)); 
        }
        
        return $this->groups[$name]; 
    }
    
    public function flatten()
    {
        $values = array(); 
        
        foreach($this->getGroups() as $groupName=>$group){
            $values[$groupName] = array(); 
            
            foreach($group->getSettings() as $settingName=>$setting){
                $values[$groupName][$settingName] = $setting->getDefault(); 
            }
        }
        
        return $values; 
    }
}