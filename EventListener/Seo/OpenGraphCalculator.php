<?php

namespace Isometriks\Bundle\SeoBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;

class OpenGraphCalculator implements SeoCalculatorInterface
{    
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $request = $event->getRequest();
        
        /**
         * Add current location
         */
        if ($request !== null) {
            $seo->addMetaProperty('og:url', $request->getUri());
        }
        
        /**
         * OpenGraph Title
         */
        if (!$seo->hasMeta('property', 'og:title')) {
            $seo->addMetaProperty('og:title', $seo->getTitle());
        }
        
        /**
         * OpenGraph Description
         */
        if (!$seo->hasMeta('property', 'og:description')) {
            $seo->addMetaProperty('og:description', $seo->getDescription());
        }
    }
}