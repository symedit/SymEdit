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
