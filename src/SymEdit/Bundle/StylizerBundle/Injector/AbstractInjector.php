<?php

namespace SymEdit\Bundle\StylizerBundle\Injector; 

use Symfony\Bundle\AsseticBundle\FilterManager;  

abstract class AbstractInjector implements InjectorInterface
{
    protected $manager; 
    
    /**
     * @return \Symfony\Bundle\AsseticBundle\FilterManager
     */
    public function getFilterManager()
    {
        return $this->manager;
    }
    
    public function setFilterManager(FilterManager $manager)
    {
        $this->manager = $manager;
    }
}