<?php

namespace Isometriks\Bundle\SymEditBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs; 

/**
 * This listener waits for an Image entity to either be loaded (postLoad) or just created (prePersist)
 * so that it can inject the kernel root directory. This allows the file uploads to go 
 * into the web folder. This could probably be made more complex to actually write to 
 * specific bundles but this should do for now. 
 */
class RootInjectableListener
{
    private $rootDir; 
    
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;     
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->setDir($args); 
    }
    
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setDir($args); 
    }
    
    public function setDir(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof RootInjectableInterface){
            $entity->setRootDir($this->rootDir); 
        }
    }
}