<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use SymEdit\Bundle\StylizerBundle\Model\Stylizer; 

use Symfony\Component\HttpKernel\Event\GetResponseEvent; 

/**
 * This listener checks requests for controllers. If it finds the @PageController annotation, 
 * and finds a corresponding Page, then it will inject it into the controller for you. 
 */
class ControllerListener
{
    private $stylizer; 
    private $controller = 'Symfony\Bundle\AsseticBundle\Controller\AsseticController'; 
    private $injected; 

    public function __construct(Stylizer $stylizer)
    {
        $this->stylizer = $stylizer; 
        $this->injected = false; 
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController(); 
        
        if(!is_array($controller)){
            return; 
        }
        
        $refl = new \ReflectionClass($controller[0]);
        
        if(!$this->injected && $refl->getName() === $this->controller){
            $this->stylizer->inject(); 
        }
    }
}