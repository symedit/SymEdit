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
use SymEdit\Bundle\WidgetBundle\Controller\WidgetController as BaseWidgetController;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Response;

class WidgetController extends BaseWidgetController
{
    /**
     * {@inheritDoc}
     */
    protected function getWidgetResponse(WidgetInterface $widget)
    {
        // Caching disabled
        if (!$this->getCacheManager()->decide()) {
            return new Response();
        }

        return parent::getWidgetResponse($widget);
    }

    /**
     * @return CacheDecisionManager
     */
    protected function getCacheManager()
    {
        return $this->container->get('symedit_cache.decision_manager');
    }

    /**
     * @return SettingsInterface
     */
    protected function getSettings()
    {
        return $this->get('symedit_settings.settings');
    }
}
