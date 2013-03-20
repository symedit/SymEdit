<?php

namespace Isometriks\Bundle\StylizerBundle\Loader; 

class ConfigData
{
    private $variables = array(); 
    
    public function addVariable($name, $data)
    {
        if(!is_array($data)){
            
            $this->variables[$name] = array(
                'value' => $data, 
            ); 
            
        } else {
            $this->variables[$name] = $data; 
        }
    }
    
    public function getVariables()
    {
        $variables = array(); 
        
        foreach($this->variables as $name => $data){
            $variables[$name] = $data['value']; 
        }
        
        return $variables; 
    }
    
    public function getVariableConfig()
    {
        return $this->variables; 
    }
}