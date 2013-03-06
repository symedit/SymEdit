<?php

namespace Isometriks\Bundle\SymEditBundle\Finder; 

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Finder\Finder;

class ResourceFinder {
    
    private $kernel; 
    private $host_bundle; 
    
    public function __construct( $host_bundle, HttpKernelInterface $kernel )
    {
        $this->host_bundle = $host_bundle; 
        $this->kernel      = $kernel; 
    }
    
    public function getTemplates($type='Page', $bundle=null)
    {
        $finder       = new Finder(); 
        $template_dir = sprintf('%s/Resources/views/%s', $this->getBundleDir($bundle), $type); 
        
        try {
            $files  = $finder->in($template_dir)->files()->name('*.twig'); 
        } catch( \Exception $e ){
            throw new \Exception(sprintf('Your %s template folder does not exist: %s', $type, $template_dir)); 
        }
        
        return $files; 
    }
    
    public function getBundleDir($bundle=null, $first=true)
    {
        if($bundle === null){
            $bundle = $this->host_bundle; 
        }
        return $this->kernel->locateResource('@'.$bundle, null, $first); 
    }
    
    public function getBundleNamespace($bundle = null)
    {
        if($bundle === null){
            $bundle = $this->getBundle(); 
        }
        
        return $this->kernel->getBundle($bundle)->getNamespace(); 
    }
    
    public function getBundle()
    {
        return $this->host_bundle; 
    }
}