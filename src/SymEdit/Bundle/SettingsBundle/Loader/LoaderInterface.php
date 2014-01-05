<?php

namespace SymEdit\Bundle\SettingsBundle\Loader; 

interface LoaderInterface
{
    public function loadSettingsData(ConfigData $settingData);
}