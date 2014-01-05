<?php

namespace Isometriks\Bundle\SettingsBundle\Twig\Extension; 

use Isometriks\Bundle\SettingsBundle\Model\Settings; 

class SettingsBundleExtension extends \Twig_Extension
{
    private $settings; 
    private $global_variable; 
    
    public function __construct(Settings $settings, $global_variable)
    {
        $this->settings = $settings; 
        $this->global_variable = $global_variable; 
    }
    
    public function getGlobals()
    {
        return array(
            $this->global_variable => $this->settings->getSettings(),   
        );
    }
    
    
    public function getName()
    {
        return 'SettingsBundleExtension'; 
    }
}