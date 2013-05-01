<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Isometriks\Bundle\SymEditBundle\Model\UpdatableInterface;  

/**
 * This listener checks to see if the class being updated is an instance
 * of the UpdatableInterface and automatically changes the last updated
 * time through the methods provided in the interface.  
 */
class UpdatableListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->update($args); 
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->update($args); 
    }
    
    private function update(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof UpdatableInterface){
            $entity->setUpdatedAt(new \DateTime()); 
        }
    }
}