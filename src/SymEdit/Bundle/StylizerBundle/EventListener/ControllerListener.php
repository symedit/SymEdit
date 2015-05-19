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

use SymEdit\Bundle\StylizerBundle\Injector\Injector;
use SymEdit\Bundle\StylizerBundle\Model\Styles;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Listens for assetic controller and injects the variables.
 */
class ControllerListener
{
    private $styles;
    private $injector;
    private $controller = 'Symfony\Bundle\AsseticBundle\Controller\AsseticController';
    private $injected;

    public function __construct(Styles $styles, Injector $injector)
    {
        $this->styles = $styles;
        $this->injector = $injector;
        $this->injected = false;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        $refl = new \ReflectionClass($controller[0]);

        if (!$this->injected && $refl->getName() === $this->controller) {
            $this->injector->inject($this->styles->getVariables());
        }
    }
}
