<?php

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
            return null;
        }

        return $this->version = require $cache;
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