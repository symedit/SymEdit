<?php

namespace SymEdit\Bundle\SettingsBundle\Loader; 

abstract class FileLoader extends AbstractLoader
{
    protected $settingFields = array('type', 'options', 'default'); 
    protected $file; 
    
    public function __construct($file)
    {
        if(!is_file($file)){
            throw new \Exception(sprintf('File "%s" does not exist.', $file)); 
        }
        
        if(!is_readable($file)){
            throw new \Exception(sprintf('File "%s" is not readable.', $file)); 
        }
        
        $this->file = $file; 
    }
    
    protected function setSettingsData(SettingData $setting, $config)
    {
        foreach($this->settingFields as $field){
            if(isset($config[$field])){
                $method = sprintf('set%s', ucfirst($field)); 
                $setting->$method($config[$field]); 
            }
        }
    }
}