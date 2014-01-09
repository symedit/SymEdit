<?php

namespace SymEdit\Bundle\SeoBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;

class MetaCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();

        /**
         * Set meta description from seo description variable
         */
        if (!$seo->hasMeta('name', 'description')) {
            $seo->addMetaName('description', $seo->getDescription());
        }
        
        /**
         * Set robots from index / follow variables
         */
        if (!$seo->hasMeta('name', 'robots')) {
            $index = $seo->getIndex() ? 'index' : 'noindex';
            $follow = $seo->getFollow() ? 'follow' : 'nofollow';
            
            $seo->addMetaName('robots', sprintf('%s, %s', $index, $follow));
        }
    }
}            