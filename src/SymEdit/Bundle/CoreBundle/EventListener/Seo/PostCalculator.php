<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;

class PostCalculator implements SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $subject = $seo->getSubject();

        if (!$subject instanceof PostInterface) {
            return;
        }

        /**
         * Add OpenGraph Image
         */
        if (($image = $subject->getImage()) !== null) {
            $seo->addMetaProperty('og:image', $image->getWebPath());
        }
    }
}
