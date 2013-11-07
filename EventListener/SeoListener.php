<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Isometriks\Bundle\SymEditBundle\Model\Seo;

class SeoListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }
        
        $request = $event->getRequest();
        
        if ($page = $request->attributes->get('_page', false)) {
            $seo = $page->getSeo();
        } else {
            $seo = array();
        }
        
        $request->attributes->set('_seo', new Seo($seo));
    }
}