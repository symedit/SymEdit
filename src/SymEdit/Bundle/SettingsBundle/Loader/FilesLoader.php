<?php

namespace Isometriks\Bundle\SettingsBundle\Loader; 

abstract class FilesLoader extends LoaderChain 
{
    public function __construct(array $paths)
    {
        parent::__construct($this->getFileLoaders($paths)); 
    }
    
    protected function getFileLoaders(array $paths)
    {
        $loaders = array();
        foreach ($paths as $path) {
            $loaders[] = $this->getFileLoaderInstance($path);
        }

        return $loaders;  
    }
    
    abstract protected function getFileLoaderInstance($file); 
}