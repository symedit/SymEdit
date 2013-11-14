<?php

namespace Isometriks\Bundle\SeoBundle\Model;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;

interface SeoCalculatorInterface
{
    public function calculateSeo(SeoEvent $event);
}