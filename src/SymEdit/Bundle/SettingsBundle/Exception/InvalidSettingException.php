<?php

namespace SymEdit\Bundle\SettingsBundle\Exception; 

class InvalidSettingException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message); 
    }
}