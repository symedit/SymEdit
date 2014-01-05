<?php

namespace SymEdit\Bundle\StylizerBundle\Loader; 

use Symfony\Component\Yaml\Yaml; 

class Loader
{
    private $rootDir; 
    private $yamlFiles; 
    
    public function __construct($rootDir, array $yamlFiles = array())
    {
        $this->rootDir = $rootDir; 
        $this->yamlFiles = $yamlFiles; 
    }
    
    public function loadStyleData(ConfigData $configData)
    {
        foreach($this->yamlFiles as $file){
            $data = Yaml::parse(file_get_contents($file));
            
            foreach($data as $name => $value){
                $configData->parseGroup($name, $value); 
            }
        }
    }
}