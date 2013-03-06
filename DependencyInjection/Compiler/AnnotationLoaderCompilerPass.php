<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AnnotationLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sensio_framework_extra.routing.loader.annot_class');
        $definition->setClass('%isometriks_sym_edit.routing.loader.controller.class%');
        $definition->addArgument($container->getDefinition('doctrine')); 
    }
}