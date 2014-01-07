<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Loader; 

class ConfigData
{
    private $groups = array(); 
    
    public function parseGroup($name, $data)
    {
        if(!isset($this->groups[$name])){
            $this->groups[$name] = new GroupData($name); 
        }
        
        $group = $this->groups[$name]; 
        
        /**
         * Allow overriding labels
         */
        if(isset($data['label'])){
            $group->setLabel($data['label']); 
        }
        
        /**
         * Add optional arguments
         */
        if(isset($data['extra'])){
            $group->addExtra($data['extra']); 
        }
        
        if(isset($data['variables'])){
            foreach($data['variables'] as $name => $value){
                $group->addVariable($name, $value); 
            }
        }
    }
    
    public function getGroups()
    {
        return $this->groups; 
    }
    
    public function getVariables()
    {
        $variables = array(); 
        
        foreach($this->getGroups() as $group){
            $variables = array_merge($variables, $group->getVariables()); 
        }
        
        return $variables; 
    }
}