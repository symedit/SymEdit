<?php

namespace SymEdit\Bundle\CoreBundle\EventListener\Seo;

use Isometriks\Bundle\SeoBundle\Event\SeoEvent;
use Isometriks\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use SymEdit\Bundle\SettingsBundle\Model\Settings;

class OpenGraphCalculator implements SeoCalculatorInterface
{
    protected $settings;
    
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
    
    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();

        if (!$seo->hasMeta('property', 'og:site_name')) {
            $seo->addMetaProperty('og:site_name', $this->settings->get('company.name'));
        }
    }
}