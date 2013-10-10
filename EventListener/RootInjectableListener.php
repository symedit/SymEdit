<?php

namespace Isometriks\Bundle\MediaBundle\EventListener;

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
    
    public function onFlush(\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager(); 
        $uow = $em->getUnitOfWork(); 
        
        foreach($uow->getScheduledEntityInsertions() as $entity){
            if($entity instanceof \Isometriks\Bundle\MediaBundle\Entity\File){
                if(($callback = $entity->getNameCallback()) !== null){

                    /**
                     * Update the Name if there is a callback
                     */
                    $oldName = $entity->getName(); 
                    $entity->setName($callback($entity)); 
                    
                    $uow->propertyChanged($entity, 'name', $oldName, $entity->getName()); 
                    
                    /**
                     * Update the path if necessary as well
                     */
                    $oldPath = $entity->getPath(); 
                    $entity->calculatePath(); 
                    
                    $uow->propertyChanged($entity, 'path', $oldPath, $entity->getPath()); 
                }
            }
        }
    }
    
    public function setDir(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof RootInjectableInterface){
            $entity->setRootDir($this->rootDir); 
        }
    }
}