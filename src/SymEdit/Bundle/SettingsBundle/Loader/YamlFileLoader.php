<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Loader;

use Symfony\Component\Yaml\Yaml;
use SymEdit\Bundle\SettingsBundle\Exception\InvalidSettingException;

class YamlFileLoader extends FileLoader
{
    protected $groups;

    public function loadSettingsData(ConfigData $configData)
    {
        if ($this->groups === null) {
            $this->groups = Yaml::parse($this->file);

            foreach ($this->groups as $groupName => $groupData) {
                
                if($configData->hasGroup($groupName)){
                    $group = $configData->getGroup($groupName); 
                } else {
                    $default_options = isset($groupData['default_options']) ? $groupData['default_options'] : array();
                    $label = isset($groupData['label']) ? $groupData['label'] : null; 
                    $role = isset($groupData['role']) ? $groupData['role'] : null; 
                    $group = $configData->createGroup($groupName, $label, $default_options, $role);
                }

                if (!isset($groupData['settings'])) {
                    continue;
                }

                foreach ($groupData['settings'] as $settingName => $settingData) {
                    $setting = new SettingData($settingName);
                    $this->setSettingsData($setting, $settingData);

                    $group->addSetting($setting);
                }
            }
        }
    }
}