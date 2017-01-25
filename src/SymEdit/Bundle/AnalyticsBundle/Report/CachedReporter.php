<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Report;

use Doctrine\Common\Cache\Cache;

class CachedReporter implements ReporterInterface
{
    private $decoratedReporter;
    private $cache;
    private $ttl;

    public function __construct(ReporterInterface $decoratedReporter, Cache $cache = null, $ttl = 600)
    {
        $this->decoratedReporter = $decoratedReporter;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    public function runReport($name, array $options = array())
    {
        $key = $this->getKey($name, $options);

        if ($this->cache->contains($key)) {
            return $this->cache->fetch($key);
        }

        $result = $this->decoratedReporter->runReport($name, $options);
        $this->cache->save($key, $result, $this->ttl);

        return $result;
    }

    private function getKey($name, array $options)
    {
        return md5(sprintf('%s_%s', $name, serialize($options)));
    }
}
