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

        if($request->attributes->has('_page_id')){
            
            $repo = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Page'); 
            
            $id = $request->attributes->get('_page_id'); 
            $request->attributes->remove('_page_id');  
 
            $page = $repo->find($id); 
            
            $request->attributes->add(array(
                '_page' => $page, 
            )); 
        }       
    }
}