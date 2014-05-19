<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Model;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;

interface SeoCalculatorInterface
{
    /**
     * This method receives the SeoEvent to allow you to modify it.
     *
     * @param SeoEvent $event The seo event
     */
    public function calculateSeo(SeoEvent $event);
}
