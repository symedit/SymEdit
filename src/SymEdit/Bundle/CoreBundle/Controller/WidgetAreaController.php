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

use SymEdit\Bundle\CacheBundle\Decision\CacheDecisionManager;
use SymEdit\Bundle\SettingsBundle\Model\SettingsInterface;
use SymEdit\Bundle\WidgetBundle\Controller\WidgetAreaController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class WidgetAreaController extends BaseController
{
    /**
     * @return Response
     */
    protected function getResponse()
    {
        $response = new Response();

        // Check if we can cache or not
        if (($cache = $this->getCacheManager()) && $cache->decide()) {
            $settings = $this->getSettings();
            $sharedMaxAge = $settings->get('widget.shared_max_age');

            // Set shared age
            $response->setSharedMaxAge($sharedMaxAge);
        }

        return $response;
    }

    /**
     * @return CacheDecisionManager
     */
    protected function getCacheManager()
    {
        return $this->container->has('symedit_cache.decision_manager') ? $this->container->get('symedit_cache.decision_manager') : false;
    }

    /**
     * @return SettingsInterface
     */
    protected function getSettings()
    {
        return $this->get('symedit_settings.settings');
    }
}
