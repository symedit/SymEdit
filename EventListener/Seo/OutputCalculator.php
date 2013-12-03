<?php

namespace Isometriks\Bundle\SeoBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use Isometriks\Bundle\SeoBundle\Util\SeoTools;

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

        /**
         * Trim title
         */
        $title = SeoTools::plain($seo->getTitle(), $this->maxTitleLength);
        $seo->setTitle($title);

        /**
         * Trim meta description
         */
        if ($seo->hasMeta('name', 'description')) {
            $description = SeoTools::plain($seo->getMetas('name', 'description'), $this->maxDescriptionLength);

            $seo->addMetaName('description', $description);
        }
    }
}