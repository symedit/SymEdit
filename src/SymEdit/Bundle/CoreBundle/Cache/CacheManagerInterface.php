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

use Symfony\Component\HttpFoundation\Response;

interface CacheManagerInterface
{
    /**
     * Returns a Response object based on the lastModified time passed in
     * and also whether or not caching is enabled.
     *
     * @param  \DateTime $lastModified
     * @return Response  Response object
     */
    public function getLastModifiedResponse(\DateTime $lastModified = null);

    public function isCacheable();
}
