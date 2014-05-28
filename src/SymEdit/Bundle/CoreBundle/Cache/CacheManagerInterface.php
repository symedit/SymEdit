<?php

namespace SymEdit\Bundle\CoreBundle\Cache;

use Symfony\Component\HttpFoundation\Response;

interface CacheManagerInterface
{
    /**
     * Returns a Response object based on the lastModified time passed in
     * and also whether or not caching is enabled.
     *
     * @param \DateTime $lastModified
     * @return Response Response object
     */
    public function getLastModifiedResponse(\DateTime $lastModified = null);

    public function isCacheable();
}