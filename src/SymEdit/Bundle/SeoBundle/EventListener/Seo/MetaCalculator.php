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

class MetaCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();

        /*
         * Set meta description from seo description variable
         */
        if (!$seo->hasMeta('name', 'description')) {
            $seo->addMetaName('description', $seo->getDescription());
        }

        /*
         * Set robots from index / follow variables
         */
        if (!$seo->hasMeta('name', 'robots')) {
            $index = $seo->getIndex() ? 'index' : 'noindex';
            $follow = $seo->getFollow() ? 'follow' : 'nofollow';

            $seo->addMetaName('robots', sprintf('%s, %s', $index, $follow));
        }
    }
}
