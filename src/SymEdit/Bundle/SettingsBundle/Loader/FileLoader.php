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