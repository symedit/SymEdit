<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Checks the request for a _page_id, and then adds the actual Page 
 * to the Request instead. 
 */
class ControllerListener
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function onKernelController(FilterControllerEvent $event)
    { 
        $request = $event->getRequest(); 
        $attributes = $request->attributes; 
        
        /**
         * Check if any request has a _page_id that needs to be converted
         */
        if($attributes->has('_page_id')){ 
            
            $repo = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Page'); 
            
            $id = $attributes->get('_page_id'); 
            $attributes->remove('_page_id');  
 
            $page = $repo->find($id); 
            
            $attributes->add(array(
                '_page' => $page, 
            )); 
        }
    }
}