<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoManagerInterface;

/**
 * Checks for a _page attribute in the request and sets that by default
 * to be the SEO, overwrite it in your controllers.
 */
class SeoControllerListener
{
    private $seoManager;

    public function __construct(SeoManagerInterface $seoManager)
    {
        $this->seoManager = $seoManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $attributes = $request->attributes;
        
        if ($attributes->has('_page')) {
            $seo = $this->seoManager->getSeo();
            $seo->setSubject($attributes->get('_page'));
        }
    }
}