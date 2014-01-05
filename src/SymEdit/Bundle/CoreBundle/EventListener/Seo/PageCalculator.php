<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;

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