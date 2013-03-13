<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler; 

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface; 
use Symfony\Component\DependencyInjection\ContainerBuilder; 

class TemplateGuesserCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if($container->hasDefinition('sensio_framework_extra.view.guesser')){
            $definition = $container->getDefinition('sensio_framework_extra.view.guesser');
            $class = $container->getParameter('isometriks_sym_edit.view.guesser.class'); 
            
            /**
             * Change the class to our guesser
             */
            $definition->setClass($class); 
            
            /**
             * Add the host_bundle
             */
            $host_bundle = $container->getParameter('isometriks_sym_edit.host_bundle'); 
            $definition->addArgument($host_bundle); 
        }
    }    
}