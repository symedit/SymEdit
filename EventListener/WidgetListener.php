<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener; 

use Isometriks\Bundle\SymEditBundle\Widget\WidgetRegistry; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Doctrine\ORM\Event\LifecycleEventArgs; 

class WidgetListener 
{
    private $registry; 
    
    public function __construct(WidgetRegistry $registry)
    {
        $this->registry = $registry; 
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity(); 
        
        if($entity instanceof WidgetInterface){
            $this->registry->injectStrategy($entity); 
        }
    }
}