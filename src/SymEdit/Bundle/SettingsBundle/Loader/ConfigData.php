<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Loader; 

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