<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use Sylius\Bundle\SettingsBundle\Model\Settings;
use SymEdit\Bundle\CacheBundle\Decision\CacheDecisionManager;
use SymEdit\Bundle\WidgetBundle\Controller\WidgetController as BaseWidgetController;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Response;

class WidgetController extends BaseWidgetController
{
    /**
     * {@inheritdoc}
     */
    protected function getWidgetResponse(WidgetInterface $widget)
    {
        // Caching disabled
        if (!$this->getCacheManager()->decide()) {
            return new Response();
        }

        $response = parent::getWidgetResponse($widget);

        // Don't add TTL if response is private / non-cacheable
        if (!$response->isCacheable()) {
            return $response;
        }

        // Get Settings for TTL
        $ttl = $this->getWidgetSettings()->get('widget_max_age');

        // Set Max Age
        $response->setSharedMaxAge($ttl);

        return $response;
    }

    /**
     * @return Settings
     */
    public function getWidgetSettings()
    {
        return $this->get('sylius.settings.manager')->loadSettings('advanced');
    }

    /**
     * @return CacheDecisionManager
     */
    protected function getCacheManager()
    {
        return $this->container->get('symedit_cache.decision_manager');
    }
}
