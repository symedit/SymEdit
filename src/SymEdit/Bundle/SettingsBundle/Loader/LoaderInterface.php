<?php

namespace Isometriks\Bundle\SettingsBundle\Loader; 

interface LoaderInterface
{
    public function loadSettingsData(ConfigData $settingData);
}