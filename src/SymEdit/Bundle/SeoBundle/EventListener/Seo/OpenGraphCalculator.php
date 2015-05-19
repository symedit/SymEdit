<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;

class OpenGraphCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $request = $event->getRequest();

        /*
         * Add current location
         */
        if ($request !== null) {
            $seo->addMetaProperty('og:url', $request->getUri());
        }

        /*
         * OpenGraph Title
         */
        if (!$seo->hasMeta('property', 'og:title')) {
            $seo->addMetaProperty('og:title', $seo->getTitle());
        }

        /*
         * OpenGraph Description
         */
        if (!$seo->hasMeta('property', 'og:description') && $seo->hasMeta('name', 'description')) {
            $seo->addMetaProperty('og:description', $seo->getMetas('name', 'description'));
        }
    }
}
