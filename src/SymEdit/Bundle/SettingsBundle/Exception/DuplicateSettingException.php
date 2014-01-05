<?php

namespace Isometriks\Bundle\SettingsBundle\Exception; 

class DuplicateSettingException extends \Exception
{
    public function __construct($groupName, $settingName)
    {
        parent::__construct(sprintf('Duplicate setting definition "%s.%s"', $groupName, $settingName )); 
    }
}