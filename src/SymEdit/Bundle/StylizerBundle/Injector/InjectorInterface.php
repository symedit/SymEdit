<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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