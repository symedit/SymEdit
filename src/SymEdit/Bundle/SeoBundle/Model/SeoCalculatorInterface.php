<?php

namespace Isometriks\Bundle\SeoBundle\Model;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;

interface SeoCalculatorInterface
{
    /**
     * This method receives the SeoEvent to allow you to modify it.
     *
     * @param SeoEvent $event The seo event
     */
    public function calculateSeo(SeoEvent $event);
}