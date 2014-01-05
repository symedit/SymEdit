<?php

namespace Isometriks\Bundle\StylizerBundle\Model; 

use Isometriks\Bundle\StylizerBundle\Loader\Loader; 
use Isometriks\Bundle\StylizerBundle\Dumper\Dumper; 
use Isometriks\Bundle\StylizerBundle\Loader\ConfigData; 
use Symfony\Component\Yaml\Yaml; 
use Symfony\Component\Filesystem\Filesystem; 

class Stylizer implements \ArrayAccess
{
    private $variables; 
    private $loader; 
    private $dumper; 
    private $configData; 
    private $rootDir; 
    private $cacheDir; 
    private $file = 'config/styles.yml'; 
    
    public function __construct(Loader $loader, Dumper $dumper, $rootDir, $cacheDir)
    {
        $this->loader = $loader; 
        $this->dumper = $dumper; 
        $this->rootDir = $rootDir; 
        $this->cacheDir = $cacheDir; 
    }
    
    public function getConfigData()
    {
        if($this->configData === null){
            $this->configData = new ConfigData(); 
            $this->loader->loadStyleData($this->configData); 
        }
        
        return $this->configData; 
    }
    
    public function getDefaultValues()
    {
        return $this->getConfigData()->getVariables(); 
    }
    
    private function getMergedValues()
    {
        $file = $this->rootDir.'/'.$this->file;
        $styles = is_file($file) && is_readable($file) ? Yaml::parse($file) : array(); 
        
        if(!is_array($styles)){
            $styles = array(); 
        }
        
        return array_replace($this->getDefaultValues(), $styles); 
    }
    
    public function getVariables()
    {
        if($this->variables === null){
            $this->variables = $this->getMergedValues(); 
        }
        
        return $this->variables; 
    }
    
    public function save()
    {
        /**
         * Remove asset cache
         */
        $fs = new Filesystem(); 
        $fs->remove($this->cacheDir); 
        
        /**
         * Save Variables
         */
        $file = $this->rootDir.'/'.$this->file;
        file_put_contents($file, Yaml::dump($this->getVariables())); 
    }
    
    public function dump()
    {
        return $this->dumper->dump(); 
    }
    
    public function inject()
    {
        $this->dumper->inject($this->getVariables()); 
    }

    public function offsetExists($offset)
    {
        $variables = $this->getVariables();
        
        return isset($variables[$offset]); 
    }

    public function offsetGet($offset)
    {
        if(!$this->offsetExists($offset)){
            throw new \Exception(sprintf('Variables "%s" does not exist.', $offset)); 
        }
        
        $variables = $this->getVariables(); 
        
        return $variables[$offset]; 
    }

    public function offsetSet($offset, $value)
    {
        // Load Variables
        $this->getVariables(); 
        
        $this->variables[$offset] = $value; 
    }

    public function offsetUnset($offset)
    {
        // Load Variables
        $this->getVariables(); 
        
        unset($this->variables[$offset]); 
    }
}