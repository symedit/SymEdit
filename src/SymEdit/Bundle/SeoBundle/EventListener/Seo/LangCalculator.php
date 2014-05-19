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
