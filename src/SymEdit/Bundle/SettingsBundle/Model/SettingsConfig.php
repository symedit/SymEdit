<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Model;

class SettingsConfig implements SettingsConfigInterface
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getDefaultValues()
    {
        $defaults = array();

        foreach ($this->getConfig() as $groupName => $groupData) {
            $defaults[$groupName] = $this->getGroupDefaults($groupData['settings']);
        }

        return $defaults;
    }

    protected function getGroupDefaults($groupData)
    {
        $defaults = array();

        foreach ($groupData as $settingName => $settingData) {
            $defaults[$settingName] = array_key_exists('default', $settingData) ? $settingData['default'] : null;
        }

        return $defaults;
    }
}
