<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use Isometriks\Bundle\SymEditBundle\Model\CategoryInterface;

class CategoryCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $subject = $seo->getSubject();
        
        if (!$subject instanceof CategoryInterface) {
            return;
        }
        
        $seo->merge(array(
            'title' => $subject->getTitle(),
            'description' => sprintf('Blog posts in %s', $subject->getTitle()),
        ));
    }
}