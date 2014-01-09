<?php

namespace Isometriks\Bundle\SeoBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;

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