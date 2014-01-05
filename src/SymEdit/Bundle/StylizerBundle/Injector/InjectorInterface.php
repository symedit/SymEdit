<?php

namespace SymEdit\Bundle\StylizerBundle\Injector; 

use Symfony\Bundle\AsseticBundle\FilterManager; 

interface InjectorInterface
{
    public function inject(array $variables = array()); 
    
    /**
     * @return \Symfony\Bundle\AsseticBundle\FilterManager Get the filter manager
     */
    public function getFilterManager(); 
    
    public function setFilterManager(FilterManager $manager); 
}