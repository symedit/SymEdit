<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Dumper;

use Symfony\Component\Config\ConfigCache;

class VersionManager
{
    protected $cacheDir;
    protected $version;

    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return ConfigCache
     */
    protected function getCache()
    {
        return new ConfigCache(
            sprintf('%s/version.php', $this->cacheDir),
            false
        );
    }

    public function getVersion()
    {
        if ($this->version !== null) {
            return $this->version;
        }

        $cache = $this->getCache();

        if (!$cache->isFresh()) {
            return;
        }

        return $this->version = require $cache->getPath();
    }

    public function setVersion($version)
    {
        $this->getCache()->write(sprintf('<?php return %s;', var_export($version, true)));

        $this->version = $version;
    }

    public function bumpVersion()
    {
        $date = new \DateTime();
        $version = md5($date->format('c'));
        $this->setVersion(substr($version, 0, 12));

        return $version;
    }
}
