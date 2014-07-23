<?php

namespace SymEdit\Bundle\CoreBundle\Cache\Voter;

use SymEdit\Bundle\CacheBundle\Decision\Voter\CacheVoterInterface;
use SymEdit\Bundle\SettingsBundle\Model\Settings;

class SettingsCacheVoter implements CacheVoterInterface
{
    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function isCacheable($resource = null)
    {
        if($this->settings->getDefault('advanced.caching', 'none') !== 'cache') {
            return self::FAIL;
        }

        return self::PASS;
    }
}
