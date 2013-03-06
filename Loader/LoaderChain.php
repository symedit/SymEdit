<?php

namespace Isometriks\Bundle\SettingsBundle\Loader; 

class LoaderChain implements LoaderInterface
{
    private $loaders; 
    
    public function __construct(array $loaders)
    {
        $this->loaders = $loaders; 
    }

    public function loadSettingsData(ConfigData $configData)
    {
        $success = false;

        foreach ($this->loaders as $loader) {
            $success = $loader->loadSettingsData($configData) || $success;
        }

        return $success;        
    } 
}