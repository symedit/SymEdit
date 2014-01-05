<?php

namespace SymEdit\Bundle\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use SymEdit\Bundle\CoreBundle\Model\BreadcrumbsInterface; 

class BreadcrumbListener
{
    private $breadcrumbs; 
    
    public function __construct(BreadcrumbsInterface $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs; 
    }
    
    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
        
        $request = $event->getRequest(); 

        if($request->attributes->has('_page')){
            
            /* @var $page \SymEdit\Bundle\CoreBundle\Model\PageInterface */
            $page = $request->attributes->get('_page'); 
            
            while($page->getParent() !== null && !$page->getHomepage()){
                $this->breadcrumbs->unshift($page->getTitle(), $page->getRoute()); 
                
                $page = $page->getParent(); 
            } 
        } 
        
        $request->attributes->add(array(
            '_breadcrumbs' => $this->breadcrumbs, 
        )); 
    }
}