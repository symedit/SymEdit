<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigExceptionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Get the symedit defined one
        $controller = $container->getParameter('isometriks_sym_edit.exception.controller.class'); 
        
        // Set twig controller
        $container->setParameter('twig.exception_listener.controller', sprintf('%s::%s', $controller, 'showAction') ); 
    }
}