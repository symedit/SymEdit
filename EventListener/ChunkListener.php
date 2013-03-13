<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener; 

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Symfony\Component\DependencyInjection\ContainerAwareInterface; 
use Doctrine\ORM\Event\LifecycleEventArgs; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 

class ChunkListener 
{
    private $container; 
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container; 
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof Chunk){
            $registry = $this->container->get('symedit.editable.chunk.registry'); 
            $registry->injectStrategy($entity); 
        }
    }
}