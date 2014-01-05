<?php

namespace SymEdit\Bundle\SettingsBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class SettingsCacheWarmer implements CacheWarmerInterface
{
    public function __construct(Settings $settings)
    {
        
    }
    
    public function warmUp($cacheDir)
    {
        
    }    
    
    public function isOptional()
    {
        return true; 
    }
}