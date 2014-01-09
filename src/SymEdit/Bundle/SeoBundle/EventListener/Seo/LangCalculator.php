<?php

namespace SymEdit\Bundle\SeoBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;

class LangCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $request = $event->getRequest();
        
        if ($request !== null) {
            $seo->addHtmlAttr('lang', $request->getLocale());
        }
    }
}            