<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener; 

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Doctrine\ORM\Event\LifecycleEventArgs; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 

class ChunkListener 
{
    private $container; 
    private $registry; 
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container; 
    }
    
    private function getRegistry()
    {
        if($this->registry === null){
            $this->registry = $this->container->get('symedit.editable.chunk.registry');
        }
        
        return $this->registry; 
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof Chunk){
            $this->getRegistry()->injectStrategy($entity); 
        }
    }
}