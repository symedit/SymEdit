<?php

namespace SymEdit\Bundle\CoreBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;

class PageCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $subject = $seo->getSubject();
        
        if (!$subject instanceof PageInterface) {
            return;
        }
        
        $seo->merge(array(
            'title' => $subject->getTitle(),
            'description' => $subject->getSummary(),
        ));
    }
}