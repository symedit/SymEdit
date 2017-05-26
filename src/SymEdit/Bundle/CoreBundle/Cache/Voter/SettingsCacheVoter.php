<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Cache\Voter;

use SymEdit\Bundle\CacheBundle\Decision\Voter\CacheVoterInterface;
use SymEdit\Bundle\SettingsBundle\Manager\SettingsManagerInterface;

class SettingsCacheVoter implements CacheVoterInterface
{
    protected $settings;

    public function __construct(SettingsManagerInterface $settings)
    {
        $this->settings = $settings;
    }

    public function isCacheable($resource = null)
    {
        $advanced = $this->settings->load('advanced');

        if ($advanced->get('caching') !== 'cache') {
            return self::FAIL;
        }

        return self::PASS;
    }
}
