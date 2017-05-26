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
use SymEdit\Bundle\SettingsBundle\Manager\SettingsManagerInterface;

class OpenGraphCalculator implements SeoCalculatorInterface
{
    protected $settings;

    public function __construct(SettingsManagerInterface $settings)
    {
        $this->settings = $settings;
    }

    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();

        if (!$seo->hasMeta('property', 'og:site_name')) {
            $company = $this->settings->load('company');
            $seo->addMetaProperty('og:site_name', $company['name']);
        }
    }
}
