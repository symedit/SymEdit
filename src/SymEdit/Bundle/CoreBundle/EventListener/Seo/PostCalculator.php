<?php

namespace SymEdit\Bundle\CoreBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use SymEdit\Bundle\CoreBundle\Model\PostInterface;

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

        $seo->merge(array(
            'title' => $subject->getTitle(),
            'description' => $subject->getSummary(),
        ));
    }
}