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
use SymEdit\Bundle\SeoBundle\Util\SeoTools;

class OutputCalculator implements SeoCalculatorInterface
{
    protected $maxTitleLength;
    protected $maxDescriptionLength;

    public function __construct($maxTitleLength, $maxDescriptionLength)
    {
        $this->maxTitleLength = $maxTitleLength;
        $this->maxDescriptionLength = $maxDescriptionLength;
    }

    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();

        /*
         * Trim title
         */
        $title = SeoTools::plain($seo->getTitle(), $this->maxTitleLength);
        $seo->setTitle($title);

        /*
         * Trim meta description
         */
        if ($seo->hasMeta('name', 'description')) {
            $description = SeoTools::plain($seo->getMetas('name', 'description'), $this->maxDescriptionLength);

            $seo->addMetaName('description', $description);
        }
    }
}
