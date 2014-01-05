<?php

namespace SymEdit\Bundle\SettingsBundle\Loader;

use Symfony\Component\Yaml\Yaml;

class XmlFileLoader extends FileLoader
{
    protected $groups;

    public function loadSettingsData(ConfigData $configData)
    {
        if ($this->groups === null) {

        }
    }
}