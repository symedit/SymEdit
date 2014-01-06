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

abstract class FilesLoader extends LoaderChain 
{
    public function __construct(array $paths)
    {
        parent::__construct($this->getFileLoaders($paths)); 
    }
    
    protected function getFileLoaders(array $paths)
    {
        $loaders = array();
        foreach ($paths as $path) {
            $loaders[] = $this->getFileLoaderInstance($path);
        }

        return $loaders;  
    }
    
    abstract protected function getFileLoaderInstance($file); 
}