<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Twig\Extension; 

use SymEdit\Bundle\SettingsBundle\Model\Settings; 

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