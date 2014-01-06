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

class LoaderChain implements LoaderInterface
{
    private $loaders; 
    
    public function __construct(array $loaders)
    {
        $this->loaders = $loaders; 
    }

    public function loadSettingsData(ConfigData $configData)
    {
        $success = false;

        foreach ($this->loaders as $loader) {
            $success = $loader->loadSettingsData($configData) || $success;
        }

        return $success;        
    } 
}