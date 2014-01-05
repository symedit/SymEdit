<?php

namespace Isometriks\Bundle\StylizerBundle\Injector; 

class LessPhpInjector extends AbstractInjector
{
    public function inject(array $variables = array())
    {
        $manager = $this->getFilterManager(); 
        
        if($manager->has('lessphp')){
            $lessphp = $manager->get('lessphp'); 
            $lessphp->setPresets($variables); 
        }
    }    
}