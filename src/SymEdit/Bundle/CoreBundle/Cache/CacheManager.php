<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Cache;

use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

class CacheManager implements CacheManagerInterface
{
    protected $settings;
    protected $security;
    protected $cacheable;

    public function __construct(Settings $settings, SecurityContextInterface $security)
    {
        $this->settings = $settings;
        $this->security = $security;
    }

    public function getLastModifiedResponse(\DateTime $lastModified = null)
    {
        $response = $this->buildResponse();

        if ($this->isCacheable()) {
            $response->setLastModified($lastModified);
        }

        return $response;
    }

    /**
     * @return Response
     */
    protected function buildResponse()
    {
        $response = new Response();

        if ($this->isCacheable()) {
            $response
                ->setMaxAge($this->settings->getDefault('advanced.ttl', 60))
                ->setPublic()
            ;
        }

        return $response;
    }

    protected function doIsCacheable()
    {
        // Check if caching is enabled
        if ($this->settings->getDefault('advanced.caching', 'none') !== 'cache') {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return false;
        }

        return true;
    }

    public function isCacheable()
    {
        if ($this->cacheable === null) {
            $this->cacheable = $this->doIsCacheable();
        }

        return $this->cacheable;
    }
}
